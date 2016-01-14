<?php

namespace MandarinMedien\MMMediaBundle;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use MandarinMedien\MMMediaBundle\DependencyInjection\Compiler\AddMediaTypeCompilerPass;
use MandarinMedien\MMMediaBundle\MediaType\MediaTypeManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MMMediaBundle extends Bundle
{


    public function __construct()
    {

        if (!Type::hasType("mmmediabundle_mediatype")) {
            Type::addType("mmmediabundle_mediatype", '\MandarinMedien\MMMediaBundle\Doctrine\DBAL\Types\MediaTypeType');
            $this->registerDoctrineTypeMapping("MmmediabundleMediaType", "mmmediabundle_mediatype");
        }
    }

    public function boot()
    {
        /* @var $mtm MediaTypeManager */
        $mtm = $this->container->get('mm_media.mediatype.manager');

        $customType = Type::getType('mmmediabundle_mediatype');
        /* @var $customType \MandarinMedien\MMMediaBundle\Doctrine\DBAL\Types\MediaTypeType */

        $customType->setMediaTypeManager($mtm);

    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddMediaTypeCompilerPass());

    }
}
