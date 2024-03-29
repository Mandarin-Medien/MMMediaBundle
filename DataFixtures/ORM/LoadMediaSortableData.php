<?php

namespace MandarinMedien\MMMediaBundle\Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use MandarinMedien\MMMediaBundle\Entity\Media;
use MandarinMedien\MMMediaBundle\Entity\MediaSortable;
use MandarinMedien\MMMediaBundle\MediaType\ImageMediaType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadMediaSortableData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(EntityManagerInterface $manager)
    {
        /*
         * creates a Media of type mm_media.type.image
         */
        $media = new Media();
        $media->setAuthor('Max Mustermann');
        $media->setCopyright('Mustermann gGmbH');
        $media->setDescription('This is a Media description.');
        $media->setName('Media-Name');

        $media->setMediaTypeMetadata(array('foo' => 'bar'));
        $media->setMediaType(new ImageMediaType());
        $media->setMediaTypeReference('image.jpg');

        /*
         * creates a MediaSortable
         */
        $mediaSortable1 = new MediaSortable();
        $mediaSortable1->setPosition(1);
        $mediaSortable1->setMedia($media);

        $this->addReference('mediaSortable-1', $mediaSortable1);

        $manager->persist($mediaSortable1);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
