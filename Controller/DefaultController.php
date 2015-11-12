<?php

namespace MandarinMedien\MMMediaBundle\Controller;

use MandarinMedien\MMMediaBundle\MediaType\ImageMediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $mmm = $this->container->get('mm_media.mediatype.manager');

        $media = $mmm->getMediaTypeMatch('img.png');


        return new Response('Hallo');
    }
}
