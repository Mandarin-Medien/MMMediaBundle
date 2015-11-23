<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 11.11.15
 * Time: 14:22
 */

namespace MandarinMedien\MMMediaBundle\MediaType;


use MandarinMedien\MMMediaBundle\Model\MediaInterface;

class YoutubeMediaType extends BaseMediaType
{
    const NAME = 'mm.media.type.youtube';

    private $loadedMetaData;

    static function check($data)
    {
        dump($data);

        if(!($id = self::checkYoutubeLink($data)))
            return;

        return new self($id);
    }

    public function getMetaData()
    {
        if($this->loadedMetaData)
        {
           return $this->loadedMetaData;
        }
        $url = sprintf('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=%s&format=json', $this->getReference());
        $data = file_get_contents($url);
        $metadata = json_decode($data,true);

        return $metadata ;
    }

    private static function checkYoutubeLink($link)
    {
        if (strlen($link) === 11) {
            return false;
        }
        if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\#\?&\"'>]+)/", $link, $matches)) {
            return $matches[1];
        }

        return false;
    }

    /**
     * @param MediaInterface $media
     * @param array|null $options
     * @return string
     */
    public function getPreview(MediaInterface $media, array $options = null)
    {
        dump($media->getMediaTypeMetadata() );
        return $media->getMediaTypeMetadata()['html'];
    }

    /**
     * get the media name
     *
     * @return string
     */
    public function getMediaName()
    {
        $this->getMetaData()['title'];
    }

}