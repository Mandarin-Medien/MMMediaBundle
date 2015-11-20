<?php

namespace MandarinMedien\MMMediaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use MandarinMedien\MMMediaBundle\Form\DataTransformer\EntityToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HiddenEntityType extends AbstractType
{

    private $manager;

    function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdTransformer($this->manager, $options['class']);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('class'))
            ->setDefaults(array(
                'invalid_message' => 'The entity does not exist.',
            ))
        ;
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'entity_hidden';
    }

}