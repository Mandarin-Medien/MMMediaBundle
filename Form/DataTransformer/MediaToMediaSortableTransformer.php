<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 19.11.15
 * Time: 14:27.
 */
namespace MandarinMedien\MMMediaBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use MandarinMedien\MMMediaBundle\Entity\MediaSortable;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MediaToMediaSortableTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return;
        }

        $media = $value->getMedia();

        return $media;
    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return;
        }

        $media = $this->manager->getRepository('MMMediaBundle:Media')
            ->find((int) $value->getId());

        if ($media === null) {
            throw new TransformationFailedException(sprintf(
                'Image %s: Assignement failed',
                $value
            ));
        }

        $mediaSortable = (new MediaSortable())
            ->setMedia($media)
            ->setPosition(0);

        return $mediaSortable;
    }
}
