<?php

namespace Azine\SocialBarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('azine_social_bar');

        $rootNode
        	->children()
	        	->scalarNode(AzineSocialBarExtension::FB_PROFILE)->info("the url to you Facebook profile")->end()
	        	->scalarNode(AzineSocialBarExtension::GOOGLE_PLUS_PROFILE)->info("the url to your Google+ profile")->end()
	        	->scalarNode(AzineSocialBarExtension::XING_PROFILE)->info("the url to your xing profile")->end()
	        	->scalarNode(AzineSocialBarExtension::LINKED_IN_PROFILE)->info("your profile-id => get it here http://developer.linkedin.com/plugins")->end()
	        	->scalarNode(AzineSocialBarExtension::TWITTER_PROFILE)->info("your twitter username")->end()
	        	->end();


        return $treeBuilder;
    }
}
