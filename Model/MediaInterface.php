<?php
/**
 * Created by PhpStorm.
 * User: tonigurski
 * Date: 11.11.15
 * Time: 14:06.
 */
namespace MandarinMedien\MMMediaBundle\Model;

use MandarinMedien\MMMediaBundle\Entity\Media;

interface MediaInterface
{
    /**
     * returns the id the the media file.
     *
     * @return mixed
     */
    public function getId();

    /**
     * returns the description the the media file.
     *
     * @return string
     */
    public function getName();

    /**
     * sets the name the the media file.
     *
     * @param string $name
     *
     * @return Media
     */
    public function setName($name);

    /**
     * returns the description the the media file.
     *
     * @return string
     */
    public function getDescription();

    /**
     * sets the description the the media file.
     *
     * @param string $description
     *
     * @return Media
     */
    public function setDescription($description);

    /**
     * returns the copyright the the media file.
     *
     * @return string
     */
    public function getCopyright();

    /**
     * sets the copyright the the media file.
     *
     * @param string $copyright
     *
     * @return Media
     */
    public function setCopyright($copyright);

    /**
     * returns the author the the media file.
     *
     * @return string
     */
    public function getAuthor();

    /**
     * sets the author the the media file.
     *
     * @param string $author
     *
     * @return Media
     */
    public function setAuthor($author);

    /**
     * returns the datetime when the the media file got created.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * sets the datetime when the the media file got created.
     *
     * @param \DateTime $createdAt
     *
     * @return Media
     */
    public function setCreatedAt($createdAt);

    /**
     * returns the datetime when the the media file got updated.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * sets the datetime when the the media file got created.
     *
     * @param \DateTime $updatedAt
     *
     * @return Media
     */
    public function setUpdatedAt($updatedAt);

    /**
     * returns the MediaType the media file.
     *
     * @return MediaTypeInterface
     */
    public function getMediaType();

    /**
     * sets the MediaType the media file.
     *
     * @param MediaTypeInterface $mediaType
     *
     * @return Media
     */
    public function setMediaType(MediaTypeInterface $mediaType);

    /**
     * returns the MediaType Reference Id of the media file.
     *
     * @return string
     */
    public function getMediaTypeReference();

    /**
     * sets the MediaType Reference Id of the media file.
     *
     * @param string $mediaTypeReference
     *
     * @return Media
     */
    public function setMediaTypeReference($mediaTypeReference);

    /**
     * returns the MediaType MetaData of the media file.
     *
     * @return array
     */
    public function getMediaTypeMetadata();

    /**
     * sets the MediaType MetaData of the media file.
     *
     * @param array $mediaTypeMetadata
     *
     * @return Media
     */
    public function setMediaTypeMetadata(array $mediaTypeMetadata);

    /**
     * returns a MediaType-MetaData-Entry of the media file.
     *
     * @param $name
     * @param null $default
     *
     * @return mixed
     */
    public function getMediaTypeMetadataValue($name, $default = null);

    /**
     * sets a MediaType-MetaData-Entry of the media file.
     *
     * @param $name
     * @param $value
     */
    public function setMediaTypeMetadataValue($name, $value);

    /**
     * removes a MediaType-MetaData-Entry of the media file.
     *
     * @param $name
     */
    public function unsetMediaTypeMetadataValue($name);
}
