<?php

namespace MandarinMedien\MMMediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class UploadType extends AbstractType
{
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
        $resolver->setDefined(array('multiple'));

        $resolver->setDefaults(array(
            'multiple' => true
        ));

        $resolver
            ->setAllowedTypes('multiple', 'boolean');
    }

    public function getName()
    {
        return 'upload';
    }
}
