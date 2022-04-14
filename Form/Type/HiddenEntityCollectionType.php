<?php
/**
 * Created by PhpStorm.
 * User: christof
 * Date: 19.11.15
 * Time: 17:12.
 */
namespace MandarinMedien\MMMediaBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use MandarinMedien\MMMediaBundle\Entity\Media;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class HiddenEntityCollectionType extends AbstractType
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('data_class');

        $resolver->setDefaults(array(
            'allow_add' => true,
            'allow_delete' => true,
            'entry_type' =>  HiddenEntityType::class,
            'entry_options' => array(
                'class' => Media::class
            ),
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getParent()
    {
        return CollectionType::class;
    }
}
