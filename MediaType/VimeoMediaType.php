<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:22.
 */
namespace MandarinMedien\MMMediaBundle\MediaType;

class VimeoMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.image';

    public static function check($data)
    {
        return new self($data);
    }
}
