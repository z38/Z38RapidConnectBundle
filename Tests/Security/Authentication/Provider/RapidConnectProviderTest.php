<?php

namespace Z38\Bundle\RapidConnectBundle\Tests\Security\Authentication\Provider;

use Lcobucci\JWT\Builder;
use Z38\Bundle\RapidConnectBundle\Security\Authentication\Provider\RapidConnectProvider;
use Z38\Bundle\RapidConnectBundle\Security\Authentication\Token\RapidConnectToken;
use Z38\Bundle\RapidConnectBundle\Tests\TestCase;

class RapidConnectProviderTest extends TestCase
{
    public function testAuthenticate()
    {
        $user = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
        $user
            ->method('getRoles')
            ->will($this->returnValue([]))
        ;

        $userProvider = $this->getMock('Symfony\Component\Security\Core\User\UserProviderInterface');
        $userProvider
            ->expects($this->once())
            ->method('loadUserByUsername')
            ->with($this->equalTo('testid'))
            ->will($this->returnValue($user))
        ;

        $tokenDecoder = $this->getMock('Z38\Bundle\RapidConnectBundle\Jwt\TokenDecoderInterface');
        $tokenDecoder
            ->expects($this->once())
            ->method('decode')
            ->will($this->returnValue($this->buildToken()))
        ;

        $provider = new RapidConnectProvider($userProvider, $tokenDecoder);

        $unauthenticatedToken = new RapidConnectToken('');

        $token = $provider->authenticate($unauthenticatedToken);

        $this->assertTrue($token->isAuthenticated());
        $this->assertSame($user, $token->getUser());
    }

    private function buildToken()
    {
        return (new Builder())
            ->setIssuer('https://rapid.example.com')
            ->setAudience('https://test.example.com')
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration(time() + 3600)
            ->set('https://aaf.edu.au/attributes', [
                'edupersontargetedid' => 'testid',
            ])
            ->getToken()
        ;
    }
}
