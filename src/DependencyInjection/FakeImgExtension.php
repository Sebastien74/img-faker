<?php

namespace FakeImgBundle\DependencyInjection;

use FakeImgBundle\Service\PlaceholderGenerator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Bundle DI extension
 */
class FakeImgExtension extends Extension
{
    /**
     * Load bundle configuration.
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('seb_fake_img.route_prefix', $config['route_prefix']);
        $container->setParameter('seb_fake_img.background_color', $config['background_color']);
        $container->setParameter('seb_fake_img.text_color', $config['text_color']);
        $container->setParameter('seb_fake_img.max_width', $config['max_width']);
        $container->setParameter('seb_fake_img.max_height', $config['max_height']);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');
    }
}