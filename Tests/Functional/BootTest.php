<?php

namespace Z38\Bundle\RapidConnectBundle\Tests\Functional;

class BootTest extends WebTestCase
{
    public function testBoot()
    {
        $kernel = $this->createKernel();
        $kernel->boot();
    }
}
