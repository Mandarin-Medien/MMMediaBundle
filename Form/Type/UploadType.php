<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 20.11.15
 * Time: 12:37.
 */
namespace MandarinMedien\MMMediaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use MandarinMedien\MMMediaBundle\Entity\Media;
use MandarinMedien\MMMediaBundle\Form\DataTransformer\MediaToMediaSortableTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
        $view->vars['allowed_filetypes'] = $options['allowed_filetypes'];
        $view->vars['max_filesize'] = $options['max_filesize'];

        $mediaEntity = $this->manager->getRepository('MMMediaBundle:Media')->find((int) $view->vars['value']);
        $view->vars['value_media_json'] = $this->getJsonFormatedMedia($mediaEntity);
        // TODO: implement MediaType Configuration
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'multiple' => false,
            'class' => Media::class,
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
        $builder->addModelTransformer(new MediaToMediaSortableTransformer($this->manager));
    }


    public function getParent()
    {
        return HiddenEntityType::class;
    }


    /**
     * @param Media $media
     *
     * @return string
     */
    public function getJsonFormatedMedia($media = null)
    {
        $data = array();

        if ($media) {
            $data[] = array(
                'id' => $media->getId(),
                'name' => $media->getMediaTypeReference(),
                'size' => false,
                'type' => '',
                'url' => '/media/'.$media->getMediaTypeReference(),
            );
        }

        return json_encode($data);
    }
}
