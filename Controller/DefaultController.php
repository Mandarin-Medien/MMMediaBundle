<?php

namespace MandarinMedien\MMMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function indexAction()
    {
        return new Response('Hallo');
    }
}
