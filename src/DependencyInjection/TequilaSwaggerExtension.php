<?php

namespace Tequila\Bundle\SwaggerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class TequilaSwaggerExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setParameter(
            'tequila_swagger.path_patterns',
            $mergedConfig['allowed_path_patterns'] ?? []
        );

        $locator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new YamlFileLoader($container, $locator);
        $loader->load('services.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'tequila_swagger';
    }
}
