<?php

namespace Z38\Bundle\RapidConnectBundle\Jwt;

interface TokenDecoderInterface
{
    public function decode($token);
}
