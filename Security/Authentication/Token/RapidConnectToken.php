<?php

namespace Z38\Bundle\RapidConnectBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class RapidConnectToken extends AbstractToken
{
    private $rawToken;

    public function __construct($rawToken, array $roles = [])
    {
        parent::__construct($roles);
        $this->setRawToken($rawToken);
        $this->setAuthenticated(count($roles) > 0);
    }

    public function setRawToken($rawToken)
    {
        $this->rawToken = $rawToken;
    }

    public function getRawToken()
    {
        return $this->rawToken;
    }

    public function getCredentials()
    {
        return '';
    }
}
