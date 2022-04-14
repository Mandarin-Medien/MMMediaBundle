<?php

namespace MandarinMedien\MMMediaBundle\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use MandarinMedien\MMMediaBundle\MediaType\MediaTypeManager;

class MediaTypeType extends StringType
{
    const NAME = 'mmmediabundle_mediatype'; // modify to match your type name

    private $mediaTypeManager;


    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return \MandarinMedien\MMMediaBundle\Model\MediaTypeInterface|mixed|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        /** @var $mtm MediaTypeManager */
        $mtm = $this->getMediaTypeManager();

        $mt = $mtm->getInstanceByName($value);

        return $mt ? $mt : null;
    }


    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed|string
     * @throws \ReflectionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ((new \ReflectionClass($value))->implementsInterface('\MandarinMedien\MMMediaBundle\Model\MediaTypeInterface')) {
            return $value->getName();
        }

        return '';
    }


    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME; // modify to match your constant name
    }

    /**
     * @return mixed
     */
    public function getMediaTypeManager()
    {
        return $this->mediaTypeManager;
    }

    /**
     * @param mixed $mediaTypeManager
     *
     * @return MediaTypeType
     */
    public function setMediaTypeManager($mediaTypeManager)
    {
        $this->mediaTypeManager = $mediaTypeManager;

        return $this;
    }

    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return sprintf('VARCHAR(%d) COMMENT \'(DC2Type:mmmediabundle_mediatype)\'', $fieldDeclaration['length']);
    }
}
