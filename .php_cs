<?php

use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\FixerInterface;

$finder = DefaultFinder::create()
    ->in(__DIR__)
;

return Config::create()
    ->level(FixerInterface::SYMFONY_LEVEL)
    ->fixers(['ordered_use', 'short_array_syntax'])
    ->finder($finder)
    ->setUsingCache(true)
;
