<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 13.11.15
 * Time: 12:09.
 */
namespace MandarinMedien\MMMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MandarinMedien\MMMediaBundle\Model\MediaInterface;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class UploadController extends Controller
{
    /**
     * retrieves and handles the ajax upload action
     * to store uploaded files on file system.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function uploadAction(Request $request)
    {

        //return new JsonResponse($request);
        #var_dump($request);
        // process the filebag

        $rawMedias = array_merge(
            $this->processUploadedFiles($request->files),
            $this->processUrls($request)
        );

        $em = $this->getDoctrine()->getManager();
        $mtm = $this->get('mm_media.mediatype.manager');

        $returnData = array();

        foreach ($rawMedias as $rawmedia) {
            if (null != ($mt = $mtm->getMediaTypeMatch($rawmedia))) {

                /** @var MediaInterface $ms */
                $ms = $mt->getEntity();
                $em->persist($ms);

                $em->flush();

                $returnData[] = array(
                    'id' => $ms->getId(),
                    'path' => $rawmedia,
                    'mediatype' => (string) $ms->getMediaType(),
                );
            }
        }

        return new JsonResponse(
            array(
                'success' => true,
                'data' => $returnData,
            )
        );
    }

    /**
     * gets the filebag and moves uploaded files to filesystem.
     *
     * @param FileBag $filebag
     *
     * @return array reference list of moved files
     */
    protected function processUploadedFiles(FileBag $filebag)
    {
        $adapter = new LocalAdapter($this->get('kernel')->getRootDir().'/../web/media');
        $filesystem = new Filesystem($adapter);

        $processed = array();

        if ($filebag->get('files')) {
            /*
             * @var UploadedFile
             */
            foreach ($filebag->get('files') as $file) {
                // get the unique filepath
                $dest = $this->createUniquePath($file);

                if ($filesystem->write($dest['path'], file_get_contents($file->getPathname()))) {
                    $processed[] = $dest['path'];
                };
            }
        }

        return $processed;
    }

    /**
     * process the given urls.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function processUrls(Request $request)
    {
        $externalRawMediaUrls = array();

        if ($request->get('urls')) {
            foreach ($request->get('urls') as $url) {
                $externalRawMediaUrls[] = $url;
            }
        }

        return $externalRawMediaUrls;
    }

    /**
     * return a unique filepath.
     *
     * @param UploadedFile $file
     *
     * @return array
     */
    protected function createUniquePath(UploadedFile $file)
    {
        $dir = 'mmmb/'.substr(strtolower((string) $file->getClientOriginalName()), 0, 2);

        $filename = str_replace(array(' ', $file->getClientOriginalExtension()), '-', $file->getClientOriginalName());

        $name = strtolower($filename.uniqid().'.'.$file->getClientOriginalExtension());

        return array(
            'dir' => $dir,
            'filename' => $name,
            'path' => $dir.'/'.$name,
        );
    }
}
