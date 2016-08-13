<?php

namespace Z38\Bundle\RapidConnectBundle\Security\Authentication\Provider;

use Exception;
use Lcobucci\JWT\Token;
use OutOfBoundsException;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Z38\Bundle\RapidConnectBundle\Jwt\TokenDecoderInterface;
use Z38\Bundle\RapidConnectBundle\Security\Authentication\Token\RapidConnectToken;
use Z38\Bundle\RapidConnectBundle\Security\User\AttributeAwareUserProviderInterface;

class RapidConnectProvider implements AuthenticationProviderInterface
{
    protected $userProvider;
    protected $tokenDecoder;
    protected $userIdentityField;

    public function __construct(UserProviderInterface $userProvider, TokenDecoderInterface $tokenDecoder)
    {
        $this->userProvider = $userProvider;
        $this->tokenDecoder = $tokenDecoder;
        $this->userIdentityField = 'edupersontargetedid';
    }

    public function authenticate(TokenInterface $token)
    {
        try {
            $jwt = $this->tokenDecoder->decode($token->getRawToken());
        } catch (Exception $e) {
            throw new AuthenticationException('Invalid JWT token.', 0, $e);
        }

        $user = $this->getUserFromToken($jwt);

        $authToken = new RapidConnectToken($token->getRawToken(), $user->getRoles());
        $authToken->setUser($user);
        $authToken->setAuthenticated(true);

        return $authToken;
    }

    protected function getUserFromToken(Token $jwt)
    {
        try {
            $attributes = (array) $jwt->getClaim('https://aaf.edu.au/attributes');
        } catch (OutOfBoundsException $e) {
            throw new AuthenticationException('Invalid JWT token.', 0, $e);
        }

        if ($this->userProvider instanceof AttributeAwareUserProviderInterface) {
            return $this->userProvider->loadUserByAttributes($attributes);
        }

        if (!isset($attributes[$this->userIdentityField])) {
            throw new AuthenticationException('Invalid JWT token.');
        }

        return $this->userProvider->loadUserByUsername($attributes[$this->userIdentityField]);
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof RapidConnectToken;
    }
}
