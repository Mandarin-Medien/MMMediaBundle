<?php
/**
 * Created by PhpStorm.
 * User: tonigurski
 * Date: 11.11.15
 * Time: 14:10
 */

namespace MandarinMedien\MMMediaBundle\Entity;


use MandarinMedien\MMMediaBundle\Form\MediaType;
use MandarinMedien\MMMediaBundle\Model\MediaInterface;
use MandarinMedien\MMMediaBundle\Model\MediaTypeInterface;

class Media implements MediaInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $copyright;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var datetime
     */
    protected $createdAt;

    /**
     * @var datetime
     */
    protected $updatedAt;

    /**
     * @var MediaTypeInterface
     */
    protected $mediaType;

    /**
     * @var string
     */
    protected $mediaTypeReference;

    /**
     * @var array
     */
    protected $mediaTypeMetadata = array();

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Media
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     * @return Media
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Media
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     * @return Media
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param datetime $updatedAt
     * @return Media
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return MediaTypeInterface
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * @param MediaTypeInterface $mediaType
     * @return Media
     */
    public function setMediaType(MediaTypeInterface $mediaType)
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    /**
     * @return string
     */
    public function getMediaTypeReference()
    {
        return $this->mediaTypeReference;
    }

    /**
     * @param string $mediaTypeReference
     * @return Media
     */
    public function setMediaTypeReference($mediaTypeReference)
    {
        $this->mediaTypeReference = $mediaTypeReference;
        return $this;
    }

    /**
     * @return array
     */
    public function getMediaTypeMetadata()
    {
        return $this->mediaTypeMetadata;
    }

    /**
     * @param array $mediaTypeMetadata
     * @return Media
     */
    public function setMediaTypeMetadata($mediaTypeMetadata)
    {
        $this->mediaTypeMetadata = $mediaTypeMetadata;
        return $this;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function getMediaTypeMetadataValue($name, $default = null)
    {
        $metadata = $this->getMediaTypeMetadata();

        return isset($metadata[$name]) ? $metadata[$name] : $default;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setMediaTypeMetadataValue($name, $value)
    {
        $metadata = $this->getMediaTypeMetadata();
        $metadata[$name] = $value;
        $this->setMediaTypeMetadata($metadata);
    }

    /**
     * @param string $name
     */
    public function unsetMediaTypeMetadataValue($name)
    {
        $metadata = $this->getMediaTypeMetadata();
        unset($metadata[$name]);
        $this->setMediaTypeMetadata($metadata);
    }


    public function __toString()
    {
        return 'image'.$this->getId();
    }
}