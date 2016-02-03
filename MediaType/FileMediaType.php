<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:21.
 */
namespace MandarinMedien\MMMediaBundle\MediaType;

class FileMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.file';

    public static function check($data)
    {
        $allowedExtension = array(
            '*',
        );

        return new self($data);
    }
}
