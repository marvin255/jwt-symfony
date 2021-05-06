<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\DependencyInjection;

use Marvin255\Jwt\Signer\Algorithm;
use Marvin255\Jwt\Signer\SecretBase;
use Marvin255\Jwt\Symfony\Profile\JwtProfile;
use Marvin255\Jwt\Validator\AudienceConstraint;
use Marvin255\Jwt\Validator\ExpirationConstraint;
use Marvin255\Jwt\Validator\NotBeforeConstraint;
use Marvin255\Jwt\Validator\SignatureConstraint;
use Marvin255\Jwt\Validator\Validator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Object that can configure DI container for set JWT profile.
 */
class ProfileDIManager
{
    private string $name;

    private array $description;

    public function __construct(string $name, array $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Registers all services related to current JWT profile.
     *
     * @param ContainerBuilder $container
     */
    public function registerProfile(ContainerBuilder $container): void
    {
        $this->registerSigner($container);
        $this->registerValidator($container);
        $this->registerProfileObject($container);
    }

    /**
     * Registers profile signer.
     *
     * @param ContainerBuilder $container
     */
    private function registerSigner(ContainerBuilder $container): void
    {
        if (!isset(Algorithm::IMPLEMENTATIONS[$this->description['signer']])) {
            return;
        }

        if (\in_array($this->description['signer'], Algorithm::HMAC)) {
            $this->registerSignerHmac($container);
        } elseif (\in_array($this->description['signer'], Algorithm::RSA)) {
            $this->registerSignerRsa($container);
        }
    }

    /**
     * Registers profile HMAC based signer.
     *
     * @param ContainerBuilder $container
     */
    private function registerSignerHmac(ContainerBuilder $container): void
    {
        $secretName = $this->createProfileServiceName('secret');

        $container
            ->register($secretName, SecretBase::class)
            ->addArgument((string) $this->description['signer_private'])
        ;

        $container
            ->register(
                $this->createSignerServiceName(),
                Algorithm::IMPLEMENTATIONS[$this->description['signer']]
            )
            ->addArgument(new Reference($secretName))
        ;
    }

    /**
     * Registers profile RSA based signer.
     *
     * @param ContainerBuilder $container
     */
    private function registerSignerRsa(ContainerBuilder $container): void
    {
        $publicKeyName = null;
        if ($this->description['signer_public'] !== null) {
            $publicKeyName = $this->createProfileServiceName('public_key');
            $container
                ->register($publicKeyName, SecretBase::class)
                ->addArgument($this->description['signer_public'])
            ;
        }

        $privateKeyName = null;
        if ($this->description['signer_private'] !== null) {
            $privateKeyName = $this->createProfileServiceName('private_key');
            $container
                ->register($privateKeyName, SecretBase::class)
                ->addArgument($this->description['signer_private'])
                ->addArgument($this->description['signer_private_password'])
            ;
        }

        $container
            ->register(
                $this->createSignerServiceName(),
                Algorithm::IMPLEMENTATIONS[$this->description['signer']]
            )
            ->addArgument($publicKeyName === null ? null : new Reference($publicKeyName))
            ->addArgument($privateKeyName === null ? null : new Reference($privateKeyName))
        ;
    }

    /**
     * Registers profile validator.
     *
     * @param ContainerBuilder $container
     *
     * @psalm-suppress UndefinedFunction
     */
    private function registerValidator(ContainerBuilder $container): void
    {
        $constraintTag = $this->createProfileServiceName('constraint');

        if (!empty($this->description['use_expiration_constraint'])) {
            $container
                ->register(
                    $this->createProfileServiceName('expiration_constraint'),
                    ExpirationConstraint::class
                )
                ->addArgument($this->description['expiration_leeway'] ?? 0)
                ->addTag($constraintTag)
            ;
        }

        if (!empty($this->description['use_not_before_constraint'])) {
            $container
                ->register(
                    $this->createProfileServiceName('not_before_constraint'),
                    NotBeforeConstraint::class
                )
                ->addArgument($this->description['not_before_leeway'] ?? 0)
                ->addTag($constraintTag)
            ;
        }

        if (!empty($this->description['use_audience_constraint'])) {
            $container
                ->register(
                    $this->createProfileServiceName('audience_constraint'),
                    AudienceConstraint::class
                )
                ->addArgument($this->description['audience'] ?? '')
                ->addTag($constraintTag)
            ;
        }

        if (!empty($this->description['signer']) && !empty($this->description['use_signature_constraint'])) {
            $signer = $this->createSignerServiceName();
            $container
                ->register(
                    $this->createProfileServiceName('signature_constraint'),
                    SignatureConstraint::class
                )
                ->addArgument(new Reference($signer))
                ->addTag($constraintTag)
            ;
        }

        $container
            ->register(
                $this->createValidatorServiceName(),
                Validator::class
            )
            ->addArgument(tagged_iterator($constraintTag))
        ;
    }

    /**
     * Registers profile itself.
     *
     * @param ContainerBuilder $container
     */
    private function registerProfileObject(ContainerBuilder $container): void
    {
        $profile = $this->createProfileServiceName('profile');
        $profileTag = $this->createBundleServiceName('registered_profiles');
        $decoder = $this->createBundleServiceName('decoder');
        $encoder = $this->createBundleServiceName('encoder');
        $builder = $this->createBundleServiceName('builder');
        $validator = $this->createValidatorServiceName();

        $profile = $container
            ->register($profile, JwtProfile::class)
            ->addArgument($this->name)
            ->addArgument(new Reference($decoder))
            ->addArgument(new Reference($encoder))
            ->addArgument(new Reference($builder))
            ->addArgument(new Reference($validator))
            ->addTag($profileTag)
        ;

        if (!empty($this->description['signer'])) {
            $signer = $this->createSignerServiceName();
            $profile->addArgument(new Reference($signer));
        }
    }

    /**
     * Creates full service name for set name related to bundle.
     *
     * @param string $name
     *
     * @return string
     */
    private function createBundleServiceName(string $name): string
    {
        return Configuration::CONFIG_NAME . ".{$name}";
    }

    /**
     * Creates full service name for set name related to profile.
     *
     * @param string $name
     *
     * @return string
     */
    private function createProfileServiceName(string $name): string
    {
        return $this->createBundleServiceName('profile') . ".{$this->name}.{$name}";
    }

    /**
     * Returns name for validator service.
     *
     * @return string
     */
    private function createValidatorServiceName(): string
    {
        return $this->createProfileServiceName('validator');
    }

    /**
     * Returns name for signer service.
     *
     * @return string
     */
    private function createSignerServiceName(): string
    {
        return $this->createProfileServiceName('signer');
    }
}
