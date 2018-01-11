<?php

namespace MandarinMedien\MMMediaBundle\Form;

use MandarinMedien\MMMediaBundle\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('copyright')
            ->add('author')
            #->add('mediaType')
            ->add('mediaTypeReference')
            ->add('mediaTypeMetadata')

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Media::class
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'mandarinmedien_mmmediabundle_media';
    }
}
