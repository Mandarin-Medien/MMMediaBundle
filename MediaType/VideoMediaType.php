<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:22
 */

namespace MandarinMedien\MMMediaBundle\MediaType;


class VideoMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.video';

    static function check($data)
    {
        return new VideoMediaType();
    }
}