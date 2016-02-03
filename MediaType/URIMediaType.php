<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:32.
 */
namespace MandarinMedien\MMMediaBundle\MediaType;

use MandarinMedien\MMMediaBundle\Model\MediaTypeInterface;

abstract class URIMediaType implements MediaTypeInterface
{
    const NAME = 'mm.media.type.uri';

    protected $raw;

    public function __construct($data)
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
        // TODO: Implement getEntity() method.
    }

    public function getMetaData()
    {
        // TODO: Implement getMetaData() method.
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
     * parse the raw data and returns an instance on match.
     *
     * @param $data
     *
     * @return MediaTypeInterface|null
     */
    public static function check($data)
    {
        return;
    }
}
