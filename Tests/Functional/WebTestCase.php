<?php

namespace Z38\Bundle\RapidConnectBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Filesystem\Filesystem;

abstract class WebTestCase extends BaseWebTestCase
{
    protected static function createKernel(array $options = [])
    {
        return new AppKernel('test', true);
    }

    protected function setUp()
    {
        $fs = new Filesystem();
        $fs->remove(sys_get_temp_dir().'/Z38RapidConnectBundle/');
    }

    protected function tearDown()
    {
        static::$kernel = null;
    }
}
