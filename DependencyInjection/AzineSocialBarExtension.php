<?php

namespace Azine\SocialBarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AzineSocialBarExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

//         if(array_key_exists(self::COUNTRIES, $config)){
//         	$config[self::COUNTRIES] = $this->checkExclusiveness($config[self::COUNTRIES]);
//         }

//         if(array_key_exists(self::ROUTES, $config)){
//         	$config[self::ROUTES] = $this->checkExclusiveness($config[self::ROUTES]);
//         }

//         $prefix = 'azine_geo_blocking_';
//         $container->setParameter($prefix."enabled", $config["enabled"]);
//         $container->setParameter($prefix."block_anonymouse_users_only", $config["block_anonymouse_users_only"]);
//         $container->setParameter($prefix."countries_whitelist", $config["countries"]["whitelist"]);
//         $container->setParameter($prefix."countries_blacklist", $config["countries"]["blacklist"]);
//         $container->setParameter($prefix."routes_whitelist", $config["routes"]["whitelist"]);
//         $container->setParameter($prefix."routes_blacklist", $config["routes"]["blacklist"]);
//         $container->setParameter($prefix."lookup_adapter", $config["lookup_adapter"]);
//         $container->setParameter($prefix."allow_private_ips", $config["allow_private_ips"]);
//         $container->setParameter($prefix."access_denied_view", $config["access_denied_view"]);
//         $container->setParameter($prefix."login_route", $config["login_route"]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

    }
}
