Getting Started
===============

Installation
------------

Add [`z38/rapid-connect-bundle`](https://packagist.org/packages/z38/rapid-connect-bundle) to your `composer.json` file:

    php composer.phar require "z38/rapid-connect-bundle"

Register the bundle in `app/AppKernel.php`:

```php
public function registerBundles()
{
    return array(
        // ...
        new Z38\Bundle\RapidConnectBundle\Z38RapidConnectBundle(),
    );
}
```

Configuration
-------------

Configure your `parameters.yml.dist` :

```yaml
    rapid_connect_url:      'https://rapid.aaf.edu.au/jwt/authnrequest/research/example'
    rapid_connect_secret:   ''
    rapid_connect_audience: 'https://example.com'
```

Configure your `security.yml` :

```yaml
firewalls:
    main:
        pattern: ^/
        anonymous: true
        rapid_connect:
            callback_path: /auth/jwt
            failure_path: /auth/failed
            issuer: "https://rapid.aaf.edu.au"
            audience: "%rapid_connect_audience%"
            login_url: "%rapid_connect_url%"
            secret: "%rapid_connect_secret%"

access_control:
    - { path: ^/auth/failed$, roles: IS_AUTHENTICATED_ANONYMOUSLY }
    - { path: ^/, roles: IS_AUTHENTICATED_FULLY }
```

Configure your `routing.yml`:

```yaml
auth_jwt:
    path: /auth/jwt
```

Add a handler to catch authentication errors:

```php
// src/AppBundle/Controller/AuthController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    /**
     * @Route("/auth/failed")
     * @Template
     */
    public function failedAction()
    {
        $error = $this->get('security.authentication_utils')->getLastAuthenticationError();

        return ['error' => $error];
    }
}
```

Further Resources
=================

* [Official Developer Docs](https://rapid.aaf.edu.au/developers)
* [Custom User Provider](user_provider.md)
