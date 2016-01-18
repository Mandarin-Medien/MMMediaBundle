<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:32
 */

namespace MandarinMedien\MMMediaBundle\MediaType;


use MandarinMedien\MMMediaBundle\Entity\Media;
use MandarinMedien\MMMediaBundle\Model\MediaInterface;
use MandarinMedien\MMMediaBundle\Model\MediaTypeInterface;

abstract class BaseMediaType implements MediaTypeInterface
{

    const NAME = 'mm.media.type.base';

    protected $raw;
    protected $media;


    public function __construct($data = null)
    {
        $this->setRaw($data);
    }


    public function getName()
    {
        return static::NAME;
    }


    public function getReference()
    {
        return $this->raw;
    }


    public function getEntity()
    {
        if(!$this->media)
        {
            $this->media = (new Media())
                ->setMediaType($this)
                ->setMediaTypeReference($this->getReference())
                ->setMediaTypeMetadata($this->getMetaData())
                ->setName($this->getMediaName())
                ->setDescription($this->getMediaDescription());
        }

        return $this->media;
    }


    public function getMetaData()
    {
       return array();
    }


    protected function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }

    public function __toString()
    {
        return static::NAME;
    }

    /**
     * parse the raw data and returns an instance on match
     *
     * @param $data
     * @return MediaTypeInterface|null
     */
    static function check($data)
    {
        return null;
    }

    /**
     * @param MediaInterface $media
     * @param array|null $options
     * @return string
     */
    public function getPreview(MediaInterface $media, array $options = null)
    {
        $self_options = Array('html' => Array('class' => array(self::NAME)));

        if(is_array($options))
            $options = array_merge_recursive($options,$self_options);
        else
            $options = $self_options;

        $name = $this->getMediaName();

        if(!$name)
            $name = basename($media->getMediaTypeReference());

        $html = '<a href="/media/' . $media->getMediaTypeReference() . '" target="_blank" class="' . implode(' ', $options['html']['class']) . '" >'.$name."</a>";

        return $html;
    }

    /**
     * get the media name
     *
     * @return string
     */
    public function getMediaName() {return '';}

    /**
     * get the media description
     *
     * @return string
     */
    public function getMediaDescription() {return '';}
}