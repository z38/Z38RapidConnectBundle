<?php

namespace Z38\Bundle\RapidConnectBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Z38\Bundle\RapidConnectBundle\DependencyInjection\Security\Factory\RapidConnectFactory;

class Z38RapidConnectBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new RapidConnectFactory());
    }
}
