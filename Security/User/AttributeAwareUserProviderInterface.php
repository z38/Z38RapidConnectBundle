<?php

namespace Z38\Bundle\RapidConnectBundle\Security\User;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

interface AttributeAwareUserProviderInterface
{
    /**
     * Loads the user for the given attributes.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param array $username The attributes
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByAttributes(array $attributes);
}
