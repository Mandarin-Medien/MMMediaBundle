<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 18:04
 */

namespace MandarinMedien\MMMediaBundle\MediaType;


use MandarinMedien\MMMediaBundle\Model\MediaTypeInterface;

class MediaTypeManager
{

    /**
     * @var  MediaTypeInterface[]
     */
    protected $mediaTypes;

    function __construct(Array $mediaTypes)
    {
        foreach ($mediaTypes as $mediaType) {
            $this->registerMediaType($mediaType);
        }
    }


    /**
     * register new mediaType
     *
     * @param string $mediaType class name of mediatype
     * @return $this
     * @throws \Exception
     */
    public function registerMediaType($mediaType)
    {
        if ($this->check($mediaType)) {
            $this->mediaTypes[(new \ReflectionClass($mediaType))->getConstant('NAME')] = $mediaType;
            return $this;
        } else {
            throw new \Exception('registered MediaType must implement \MandarinMedien\MMMediaBundle\Model\MediaTypeInterface');
        }
    }


    /**
     * get registered MediaTypes
     * @return \MandarinMedien\MMMediaBundle\Model\MediaTypeInterface[]
     */
    public function getMediaTypes()
    {
        return $this->mediaTypes;
    }


    /**
     * return a new instance of best-matching MediaType
     *
     * @param string|array $data raw media data
     * @return MediaTypeInterface|null
     */
    public function getMediaTypeMatch($data)
    {
        foreach ($this->getMediaTypes() as $mediaTypeClass) {
            $instance = forward_static_call(array($mediaTypeClass, 'check'), $data);

            if ($instance) return $instance;
        }
    }


    /**
     * check if given class implements MediaTypeInterface
     *
     * @param $mediaType
     * @return bool
     */
    protected function check($mediaType)
    {
        return (new \ReflectionClass($mediaType))
            ->implementsInterface('\MandarinMedien\MMMediaBundle\Model\MediaTypeInterface');

    }

    /**
     * @param $name
     * @return MediaTypeInterface|null
     */
    public function getInstanceByName($name)
    {
        $mts = $this->getMediaTypes();

        if (isset($mts[$name])) {

            return new $mts[$name];
        }

        return null;
    }
}