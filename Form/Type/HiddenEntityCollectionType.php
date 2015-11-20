<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 19.11.15
 * Time: 17:12
 */

namespace MandarinMedien\MMMediaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class HiddenEntityCollectionType extends AbstractType
{

    private $manager;

    function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }


    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setRequired('data_class');

        $resolver->setDefaults(array(
            'allow_add' => true,
            'allow_delete' => true,
            'type' => new HiddenEntityType($this->manager),
            'options' => array(
                'class' => 'MandarinMedien\MMMediaBundle\Entity\Media'
            )
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }


    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'entity_collection_hidden';
    }
}