<?php

namespace MandarinMedien\MMMediaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use MandarinMedien\MMMediaBundle\Entity\Media;
use MandarinMedien\MMMediaBundle\Form\DataTransformer\MediaToMediaSortableCollectionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class UploadCollectionType extends AbstractType
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
        $view->vars['allowed_filetypes'] = $options['allowed_filetypes'];
        $view->vars['value_media_json'] = $this->getJsonFormatedMedias($view->vars['value']);
        // TODO: implement MediaType Configuration
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'multiple' => true,
            'allowed_filetypes' => null,
        ));

        $resolver->setDefined('max_filesize');

        $resolver
            ->setAllowedTypes('multiple', 'boolean')
            ->setAllowedTypes('allowed_filetypes', array('null', 'array'))
            ->setAllowedTypes('max_filesize', array("integer"));

        $resolver->setDefault("max_filesize", 0);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new MediaToMediaSortableCollectionTransformer($this->manager));
    }

    public function getParent()
    {
        return HiddenEntityCollectionType::class;
    }


    /**
     * @param Media[] $medias
     *
     * @return string
     */
    public function getJsonFormatedMedias($medias)
    {
        $array = array();

        foreach ($medias as $media) {
            $array[] = array(
                'id' => $media->getId(),
                'name' => $media->getMediaTypeReference(),
                'size' => false,
                'type' => '',
                'url' => '/media/'.$media->getMediaTypeReference(),
            );
        }

        return json_encode($array);
    }
}
