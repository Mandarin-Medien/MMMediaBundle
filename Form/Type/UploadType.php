<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 20.11.15
 * Time: 12:37
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
        $view->vars['value_media_json'] = $this->getJsonFormatedMedia(($view->vars['value'] ?: null));
        // TODO: implement MediaType Configuration
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'multiple' => false,
            'class' => 'MandarinMedien\MMMediaBundle\Entity\Media'
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
        return 'entity_hidden';
    }


    public function getName()
    {
        return 'mmmedia_upload';
    }

    /**
     * @param Media $media
     * @return string
     */
    public function getJsonFormatedMedia(Media $media = null)
    {

        $data = array();

        if($media) {
            $data[] = array(
                'id' => $media->getId(),
                'name' => $media->getMediaTypeReference(),
                'size' => false,
                'type' => '',
                'url' => "/media/" . $media->getMediaTypeReference()
            );
        }

        return json_encode($data);
    }
}
