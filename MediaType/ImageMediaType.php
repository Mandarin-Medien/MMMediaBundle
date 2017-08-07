<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:21.
 */
namespace MandarinMedien\MMMediaBundle\MediaType;

use MandarinMedien\MMMediaBundle\Model\MediaInterface;

class ImageMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.image';

    /**
     * @TODO: implement extra file object check
     *
     * @param $data
     *
     * @return ImageMediaType|null
     */
    public static function check($data)
    {
        $allowedExtensions = array(
            'png',
            'jpeg',
            'jpg',
            'gif',
            'tiff',
        );

        if (in_array(strtolower(pathinfo($data, PATHINFO_EXTENSION)), $allowedExtensions)) {
            return new self($data);
        } else {
            return;
        }
    }

    /**
     * @param MediaInterface $media
     * @param array|null     $options
     *
     * @return string
     */
    public function getPreview(MediaInterface $media, array $options = null)
    {
        $self_options = array('html' => array('class' => array(self::NAME),
																							'alt' => ''));

        if (is_array($options)) {
            $options = array_merge_recursive($options, $self_options);
        } else {
            $options = $self_options;
        }

        $html = '<img src="/media/'.$media->getMediaTypeReference().'" class="'.implode(' ', $options['html']['class']).'" alt="'.$options['html']['alt'].'"  />';

        return $html;
    }
}
