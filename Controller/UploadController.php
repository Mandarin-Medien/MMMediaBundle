<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 13.11.15
 * Time: 12:09.
 */
namespace MandarinMedien\MMMediaBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MandarinMedien\MMMediaBundle\MediaType\MediaTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MandarinMedien\MMMediaBundle\Model\MediaInterface;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class UploadController extends AbstractController
{



    /**
     * @var HttpKernelInterface
     */
    private $kernel;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var MediaTypeManager
     */
    private $mediaTypeManager;

    public function __construct(KernelInterface $kernel, EntityManagerInterface $manager, MediaTypeManager $mediaTypeManager)
    {
        $this->kernel = $kernel;
        $this->manager = $manager;
        $this->mediaTypeManager = $mediaTypeManager;
    }

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

        $em = $this->manager;
        $mtm = $this->mediaTypeManager;

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


        $v3path = $this->kernel->getRootDir().'/../web/media';
        $v4path = $this->kernel->getRootDir().'/../public/media';
        $path = $v3path;


        if(is_dir($v4path)) {
            $path = $v4path;
        }


        $adapter = new LocalAdapter($path);
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
        $dir = 'mmmb/'.mb_substr(mb_strtolower((string) $file->getClientOriginalName()), 0, 2);

        $filename = str_replace(array(' ', $file->getClientOriginalExtension()), '-', $file->getClientOriginalName());

        $name = mb_strtolower($filename.uniqid().'.'.$file->getClientOriginalExtension());

        return array(
            'dir' => $dir,
            'filename' => $name,
            'path' => $dir.'/'.$name,
        );
    }
}
