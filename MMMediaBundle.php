<?php

namespace MandarinMedien\MMMediaBundle;

use MandarinMedien\MMMediaBundle\DependencyInjection\Compiler\AddMediaTypeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MMMediaBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddMediaTypeCompilerPass());
    }

}
