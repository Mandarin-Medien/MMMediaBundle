<?php

namespace MandarinMedien\MMMediaBundle;

use MandarinMedien\MMMediaBundle\DependencyInjection\Compiler\AddMediaTypeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Form\Forms;
use MandarinMedien\MMMediaBundle\Form\Guess\MediaFormTypeGuesser;

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
