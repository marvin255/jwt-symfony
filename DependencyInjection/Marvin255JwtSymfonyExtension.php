<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\DependencyInjection;

use Exception;
use Marvin255\Jwt\Symfony\Profile\JwtProfile;
use Marvin255\Jwt\Validator\AudienceConstraint;
use Marvin255\Jwt\Validator\ExpirationConstraint;
use Marvin255\Jwt\Validator\NotBeforeConstraint;
use Marvin255\Jwt\Validator\Validator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Object tha defines all bundle data.
 */
class Marvin255JwtSymfonyExtension extends Extension
{
    /**
     * {@inheritDoc}
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loadedConfig = $this->loadConfigurationToContainer($configs, $container);
        $this->loadServicesToContainer($loadedConfig, $container);
    }

    /**
     * Registers bundle configurations.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @return array
     */
    private function loadConfigurationToContainer(array $configs, ContainerBuilder $container): array
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loadedConfig = [];
        foreach ($config as $key => $value) {
            $prefixedKey = Configuration::CONFIG_NAME . '.' . $key;
            $container->setParameter($prefixedKey, $value);
            $loadedConfig[$key] = $value;
        }

        return $loadedConfig;
    }

    /**
     * Registers bundle services.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    private function loadServicesToContainer(array $configs, ContainerBuilder $container): void
    {
        $configDir = \dirname(__DIR__) . '/Resources/config';

        $loader = new YamlFileLoader($container, new FileLocator($configDir));
        $loader->load('services.yaml');

        foreach ($configs['profiles'] as $profileName => $profileDescription) {
            $this->registerProfile($profileName, $profileDescription, $container);
        }
    }

    /**
     * Registers JWT profile.
     *
     * @param string           $name
     * @param array            $description
     * @param ContainerBuilder $container
     *
     * @psalm-suppress UndefinedFunction
     */
    private function registerProfile(string $name, array $description, ContainerBuilder $container): void
    {
        $prefix = Configuration::CONFIG_NAME . ".profile.{$name}";

        $expirationConstraint = "{$prefix}.expiration_constraint";
        $notBeforeConstraint = "{$prefix}.not_before_constraint";
        $audienceConstraint = "{$prefix}.audience_constraint";
        $constraintTag = "{$prefix}.constraints";
        $validatorAlias = "{$prefix}.validator";
        $profileAlias = "{$prefix}.profile";
        $profileTag = Configuration::CONFIG_NAME . '.registered_profiles';

        if (!empty($description['use_expiration_constraint'])) {
            $container
                ->register($expirationConstraint, ExpirationConstraint::class)
                ->addArgument($description['expiration_leeway'])
                ->addTag($constraintTag)
            ;
        }

        if (!empty($description['use_not_before_constraint'])) {
            $container
                ->register($notBeforeConstraint, NotBeforeConstraint::class)
                ->addArgument($description['not_before_leeway'])
                ->addTag($constraintTag)
            ;
        }

        if (!empty($description['use_audience_constraint'])) {
            $container
                ->register($audienceConstraint, AudienceConstraint::class)
                ->addArgument($description['audience'])
                ->addTag($constraintTag)
            ;
        }

        $container
            ->register($validatorAlias, Validator::class)
            ->addArgument(tagged_iterator($constraintTag))
        ;

        $container
            ->register($profileAlias, JwtProfile::class)
            ->addArgument($name)
            ->addArgument(new Reference(Configuration::CONFIG_NAME . '.decoder'))
            ->addArgument(new Reference(Configuration::CONFIG_NAME . '.encoder'))
            ->addArgument(new Reference(Configuration::CONFIG_NAME . '.builder'))
            ->addArgument(new Reference($validatorAlias))
            ->addTag($profileTag)
        ;
    }
}
