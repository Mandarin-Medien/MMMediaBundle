<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 13.11.15
 * Time: 12:09
 */

namespace MandarinMedien\MMMediaBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
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
     * to store uploaded files on file system
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAction(Request $request)
    {

        //return new JsonResponse($request);

        // process the filebag
        $medias = array_merge(
            $this->processUploadedFiles($request->files),
            $this->processUrls(Array())
        );


        $em = $this->getDoctrine()->getManager();
        $mtm = $this->get('mm_media.mediatype.manager');

        $returnData = array();

        foreach($medias as $media) {
            if(null != ($mt = $mtm->getMediaTypeMatch($media))) {

                /** @var MediaInterface $ms */
                $ms = $mt->getEntity();
                $em->persist($ms);

                $em->flush();

                $returnData[] = array(
                    'id' => $ms->getId(),
                    'path' => $ms->getMediaTypeReference(),
                    'mediatype' => (string) $ms->getMediaType()
                );
            }
        }

        return new JsonResponse(
            array(
                'success' => true,
                'data' => $returnData
            )
        );
    }


    /**
     * gets the filebag and moves uploaded files to filesystem
     *
     * @param FileBag $filebag
     * @return array reference list of moved files
     */
    protected function processUploadedFiles(FileBag $filebag)
    {
        $adapter = new LocalAdapter($this->get('kernel')->getRootDir() . '/../web/media');
        $filesystem = new Filesystem($adapter);


        $processed = array();


        /**
         * @var UploadedFile $file
         */
        foreach($filebag->get('files') as $file)
        {
            // get the unique filepath
            $dest = $this->createUniquePath($file);

            if($filesystem->write($dest['path'], file_get_contents($file->getPathname()))){
                $processed[] = $dest['path'];
            };
        }

        return $processed;
    }


    /**
     * process the given urls
     *
     * @param array $urls
     * @return array reference list of the urls
     */
    protected function processUrls(array $urls)
    {
        return array();
    }


    /**
     * return a unique filepath
     *
     * @param UploadedFile $file
     * @return array
     */
    protected function createUniquePath(UploadedFile $file)
    {
        $unique = uniqid();
        $dir = substr((string) $unique, 0, 2);
        $name = $file->getClientOriginalName().'.'.uniqid().'.'.$file->getClientOriginalExtension();

        return Array(
            'dir' => $dir,
            'filename' => $name,
            'path' => $dir.'/'.$name
        );
    }
}