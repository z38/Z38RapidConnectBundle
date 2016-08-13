<?php

namespace Z38\Bundle\RapidConnectBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

class RapidConnectFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->addOption('callback_path', '/auth/jwt');
        $this->addOption('issuer', 'https://rapid.aaf.edu.au');
        unset($this->options['check_path']);
        unset($this->options['use_forward']);
    }

    public function getPosition()
    {
        return 'form';
    }

    public function getKey()
    {
        return 'rapid-connect';
    }

    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->scalarNode('login_url')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('audience')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }

    protected function getListenerId()
    {
        return 'rapid_connect.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $tokenDecoderId = $this->createTokenDecoder($container, $id, $config);

        $provider = 'rapid_connect.security.authentication.provider.'.$id;
        $container
            ->setDefinition($provider, new DefinitionDecorator('rapid_connect.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(1, new Reference($tokenDecoderId))
        ;

        return $provider;
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'rapid_connect.security.entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('rapid_connect.security.entry_point'))
            ->replaceArgument(0, $config['login_url'])
        ;

        return $entryPointId;
    }

    protected function createTokenDecoder($container, $id, $config)
    {
        $tokenDecoderId = 'rapid_connect.jwt.token_decoder.'.$id;
        $container
            ->setDefinition($tokenDecoderId, new DefinitionDecorator('rapid_connect.jwt.token_decoder'))
            ->replaceArgument(0, $config['issuer'])
            ->replaceArgument(1, $config['audience'])
            ->replaceArgument(2, $config['secret'])
        ;

        return $tokenDecoderId;
    }
}
