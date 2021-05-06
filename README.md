# JWT

[![Build Status](https://github.com/marvin255/jwt-symfony/workflows/marvin255_jwt_symfony/badge.svg)](https://github.com/marvin255/jwt-symfony/actions?query=workflow%3A%22jwt_symfony%22)

Symfony bundle for [marvin255/jwt](https://github.com/marvin255/jwt) lib.



## Installation

Install bundle via composer

```shell
composer req marvin255/jwt-symfony
```



## Configuration

Set up one or more profiles in configuration

```yaml
# config/packages/marvin255_jwt_symfony.yaml
marvin255_jwt_symfony:
    profiles:
        basic:
            signer: RS256                                 # signer algorithm
            signer_public: 'file:///path/to/public.key'   # path to public key
            signer_private: 'file:///path/to/private.key' # path to private key
            signer_private_password: 'password'           # password for private key
            use_signature_constraint: true                # allow signature validation
            use_not_before_constraint: true               # allow not before validation
            not_before_leeway: 2                          # leeway to check nbf header
            use_expiration_constraint: true               # allow expiration validation
            expiration_leeway: 2                          # leeway to check exp header
            use_audience_constraint: true                 # allow audience validation
            audience: 'test'                              # audience to check
```



## Usage

```php
use Marvin255\Jwt\Symfony\Profile\JwtProfileManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use RuntimeException;

class SiteController extends AbstractController
{
    private JwtProfileManager $manager;

    public function __construct(JwtProfileManager $manager)
    {
        $this->manager = $manager;
    }

    public function read(Request $request): void
    {
        // select profile
        $jwtProfile = $this->jwtProfileManager->profile('basic');

        $tokenHeader = $request->headers->get('Authorization');

        // decode token from header string
        $token = $jwtProfile->getDecoder()->decodeString($tokenHeader);

        // validate token
        $validationResult = $jwtProfile->getValidator()->validate($token);
        if (!$validationResult->isValid()) {
            $message = implode('. ', $validationResult->getErrors());
            throw new RuntimeException($message);
        }
    }

    public function build(): void
    {
        // select profile
        $jwtProfile = $this->jwtProfileManager->profile('basic');

        // decode token from header string
        $token = $jwtProfile
            ->getBuilder()
            ->setJoseParam('test', 'test') // any custom JOSE param
            ->setIss('test')               // registered claims have own setters
            ->setClaim('test', 'test')     // any custom claim
            ->build();
    }
}
```
