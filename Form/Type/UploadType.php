<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 20.11.15
 * Time: 12:37
 */

namespace MandarinMedien\MMMediaBundle\Form\Type;


class UploadType
{

    public function getParent()
    {
        return 'entity_hidden';
    }


    public function getName()
    {
        return 'mmmedia_upload';
    }
}