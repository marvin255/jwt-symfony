<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Object tha defines all bundle data.
 *
 * @internal
 */
final class Marvin255JwtSymfonyExtension extends Extension
{
    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loadedConfig = $this->loadConfigurationToContainer($configs, $container);
        $this->loadServicesToContainer($loadedConfig, $container);
    }

    /**
     * Registers bundle configurations.
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
     * @throws \Exception
     */
    private function loadServicesToContainer(array $configs, ContainerBuilder $container): void
    {
        $configDir = \dirname(__DIR__) . '/Resources/config';

        $loader = new YamlFileLoader($container, new FileLocator($configDir));
        $loader->load('services.yaml');

        foreach ($configs['profiles'] as $profileName => $profileDescription) {
            $profileManager = new ProfileDIManager($profileName, $profileDescription);
            $profileManager->registerProfile($container);
        }
    }
}
