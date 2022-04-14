<?php

namespace MandarinMedien\MMMediaBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    public function __construct(EntityManagerInterface $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
    }

    public function transform($entity)
    {
        if (null === $entity) {
            return;
        }

        return $entity->getId();
    }

    public function reverseTransform($id)
    {
        if (!$id) {
            return;
        }

        $entity = $this->objectManager
            ->getRepository($this->class)
            ->find($id);

        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}
