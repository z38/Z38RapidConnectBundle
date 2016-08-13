<?php

namespace Z38\Bundle\RapidConnectBundle\Security\Http\EntryPoint;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class RapidConnectEntryPoint implements AuthenticationEntryPointInterface
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->url);
    }
}
