<?php

namespace Z38\Bundle\RapidConnectBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Z38\Bundle\RapidConnectBundle\Security\Authentication\Token\RapidConnectToken;

class RapidConnectListener extends AbstractAuthenticationListener
{
    protected function requiresAuthentication(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        return $this->httpUtils->checkRequestPath($request, $this->options['callback_path']);
    }

    protected function attemptAuthentication(Request $request)
    {
        $token = new RapidConnectToken($request->request->get('assertion'));

        return $this->authenticationManager->authenticate($token);
    }
}
