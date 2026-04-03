# JWT

[![Build Status](https://github.com/marvin255/jwt-symfony/workflows/jwt_symfony/badge.svg)](https://github.com/marvin255/jwt-symfony/actions?query=workflow%3A%22jwt_symfony%22)

Symfony bundle for the [marvin255/jwt](https://github.com/marvin255/jwt) library.



## Installation

Install the bundle via Composer

```shell
composer req marvin255/jwt-symfony
```



## Configuration

Set up one or more profiles in your configuration

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

final class SiteController extends AbstractController
{
    public function __construct(private JwtProfileManager $jwtProfileManager)
    {
    }

    public function read(Request $request): void
    {
        // Select profile
        $jwtProfile = $this->jwtProfileManager->profile('basic');

        $tokenHeader = $request->headers->get('Authorization');

        // Decode the token from the header string
        $token = $jwtProfile->getDecoder()->decodeString($tokenHeader);

        // Validate the token
        $validationResult = $jwtProfile->getValidator()->validate($token);
        if (!$validationResult->isValid()) {
            $message = implode('. ', $validationResult->getErrors());
            throw new RuntimeException($message);
        }
    }

    public function build(): void
    {
        // Select profile
        $jwtProfile = $this->jwtProfileManager->profile('basic');

        // Build a token
        $token = $jwtProfile
            ->getBuilder()
            ->setJoseParam('test', 'test') // Any custom JOSE parameter
            ->setIss('test')               // Registered claims have their own setters
            ->setClaim('test', 'test')     // Any custom claim
            ->build();
    }
}
```
