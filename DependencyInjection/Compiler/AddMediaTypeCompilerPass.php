<?php

namespace MandarinMedien\MMMediaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class AddMediaTypeCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        //load the configured MediaTypes
        $media_types = $container->getDefinitions('mm_media.media_types.types');

        if ( count($media_types)>0)
        {
            //load the MediaTypeManger by service
            $mediaTypeManager = $container->get('mm_media.mediatype.manager');

            if($mediaTypeManager)
            {
                //assign MediaTypes to the Manager
                $mediaTypeManager->setMediaTypes($media_types);
            }

        }

    }


}
