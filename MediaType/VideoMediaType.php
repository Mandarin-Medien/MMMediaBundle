<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:22.
 */
namespace MandarinMedien\MMMediaBundle\MediaType;

class VideoMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.video';

    public static function check($data)
    {
        $allowedExtensios = array(
            'mp4',
            'wmv',
            'm4v',
            'mov',
        );

        if (in_array(pathinfo($data, PATHINFO_EXTENSION), $allowedExtensios)) {
            return new self($data);
        } else {
            return;
        }
    }
}
