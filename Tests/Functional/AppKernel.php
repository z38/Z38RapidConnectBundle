<?php

namespace Z38\Bundle\RapidConnectBundle\Tests\Functional;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Z38\Bundle\RapidConnectBundle\Z38RapidConnectBundle(),
            new \Z38\Bundle\RapidConnectBundle\Tests\Functional\TestBundle\TestBundle(),
        ];

        return $bundles;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/Z38RapidConnectBundle/';
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/Z38RapidConnectBundle/';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
    }
}
