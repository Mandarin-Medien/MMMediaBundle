<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:23
 */

namespace MandarinMedien\MMMediaBundle\Model;


interface MediaTypeInterface
{
    static function check($data);

    public function getName();

    public function getMetaData();

    public function getReference();

    public function getEntity();
}