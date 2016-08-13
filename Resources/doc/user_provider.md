Custom User Provider
====================

To access all attributes that Rapid Connect made available to you, you can implement a custom user provider:

```php
// src/AppBundle/Security/User/UserProvider.php
namespace AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Z38\Bundle\RapidConnectBundle\Security\User\AttributeAwareUserProviderInterface;

class UserProvider implements UserProviderInterface, AttributeAwareUserProviderInterface
{
    public function loadUserByAttributes(array $attributes)
    {
        // Access all attributes as described on https://rapid.aaf.edu.au/developers
        $id = $attributes['edupersontargetedid'];
        $displayName = $attributes['displayname'];

        // Fetch or create user
        // $user = ...

        return $user;
    }

    // ...
}
```
