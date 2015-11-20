<?php

namespace MandarinMedien\MMMediaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use MandarinMedien\MMMediaBundle\Form\DataTransformer\MediaToMediaSortableTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class UploadType extends AbstractType
{

    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['multiple'] = $options['multiple'];
        // TODO: implement MediaType Configuration
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'multiple' => true
        ));

        $resolver
            ->setAllowedTypes('multiple', 'boolean');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new MediaToMediaSortableTransformer($this->manager));
    }


    public function getParent()
    {
        return 'entity_collection_hidden';
    }


    public function getName()
    {
        return 'upload';
    }
}
