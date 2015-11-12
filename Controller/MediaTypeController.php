<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 16:39
 */

namespace MandarinMedien\MMMediaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MediaTypeController extends Controller
{
    /**
     * get the matching MediaType by raw media data
     *
     * @param $data string|array
     * @return MediaTypeInterface
     */
    public function getMediaTypeByRaw($data)
    {
       dump($this->get());
    }

}