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

    /**
     * @TODO: implement extra file object check
     *
     * @param $data
     * @return ImageMediaType|null
     */
    static function check($data)
    {
        $allowedExtensions = array(
            'png',
            'jpeg',
            'jpg',
            'gif',
            'tiff'
        );

        if(in_array(strtolower(pathinfo($data, PATHINFO_EXTENSION)), $allowedExtensions)) {
            return new self($data);
        } else {
            return null;
        }
    }
}