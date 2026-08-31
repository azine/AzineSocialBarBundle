<?php

namespace Azine\SocialBarBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AzineSocialBarExtension extends Extension
{
    public const PREFIX = 'azine_social_bar_';
    public const FB_PROFILE = 'fb_profile_url';
    public const XING_PROFILE = 'xing_profile_url';
    public const LINKED_IN_PROFILE = 'linked_in_company_id';
    public const GOOGLE_PLUS_PROFILE = 'google_plus_profile_url';
    public const TWITTER_PROFILE = 'twitter_username';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        foreach ([
            self::FB_PROFILE,
            self::XING_PROFILE,
            self::LINKED_IN_PROFILE,
            self::GOOGLE_PLUS_PROFILE,
            self::TWITTER_PROFILE,
        ] as $key) {
            $container->setParameter(self::PREFIX.$key, $config[$key]);
        }

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
