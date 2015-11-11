<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:21
 */

namespace MandarinMedien\MMMediaBundle\MediaType;


class ImageMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.image';

    static function check($data)
    {
        return new ImageMediaType();
    }
}