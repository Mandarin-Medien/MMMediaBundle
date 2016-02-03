<?php

namespace MandarinMedien\MMMediaBundle\Entity;

/**
 * MediaSortable.
 */
class MediaSortable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \stdClass
     */
    private $media;

    /**
     * @var int
     */
    private $position;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set media.
     *
     * @param Media $media
     *
     * @return MediaSortable
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media.
     *
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return MediaSortable
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * getter passtrough to $this->media.
     *
     * @return mixed
     */
    public function __get($name)
    {
        return call_user_func(array($this->getMedia(), 'get'.ucfirst($name)));
    }

    /**
     * setter passtrough to $this->media.
     *
     * * @return mixed
     */
    public function __set($name, $value)
    {
        return call_user_func(array($this->getMedia(), 'set'.ucfirst($name)), $value);
    }

    /**
     * function passtrough to $this->media.
     *
     * @return mixed
     */
    public function __call($func, $args)
    {
        return call_user_func(array($this->getMedia(), $func), $args);
    }

    public function __toString()
    {
        return 'image'.$this->getId();
    }
}
