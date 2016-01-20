<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 19.11.15
 * Time: 14:27
 */

namespace MandarinMedien\MMMediaBundle\Form\DataTransformer;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\PersistentCollection;
use MandarinMedien\MMMediaBundle\Entity\MediaSortable;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MediaToMediaSortableCollectionTransformer implements DataTransformerInterface
{

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($value)
    {
        if (null === $value)
            return;

        $sortables = $value->toArray();
        array_walk($sortables, function (MediaSortable &$sortable) {
            $sortable = $sortable->getMedia();
        });

        return $sortables;

    }

    public function reverseTransform($collection)
    {
        if (null === $collection)
            return;

        array_walk($collection, function (&$item, $pos) {
            // create an new MediaSortableEntity
            $media = $this->manager->getRepository('MMMediaBundle:Media')
                ->find((int)$item->getId());

            if ($media === null) {
                throw new TransformationFailedException(sprintf(
                    'Image #%s: Assignement failed',
                    $item->getId()
                ));
            }

            $item = (new MediaSortable())
                ->setMedia($media)
                ->setPosition((int)$pos);
        });

        return $collection;
    }
}