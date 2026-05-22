<?php

namespace Azine\SocialBarBundle\Tests\DependencyInjection;

use Azine\SocialBarBundle\DependencyInjection\AzineSocialBarExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class AzineSocialBarExtensionTest extends TestCase
{
    private ContainerBuilder $configuration;

    public function testMinimalConfig(): void
    {
        $loader = new AzineSocialBarExtension();
        $loader->load([$this->getMinimalConfig()], new ContainerBuilder());

        self::assertTrue(true);
    }

    public function testFullConfigWithValues(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader = new AzineSocialBarExtension();
        $loader->load([$this->getFullConfigWithValues()], $this->configuration);

        self::assertSame('http://fb.profile.url.com', $this->configuration->getParameter('azine_social_bar_fb_profile_url'));
        self::assertSame('http://xing.profile.url.com', $this->configuration->getParameter('azine_social_bar_xing_profile_url'));
        self::assertSame(1234567890, $this->configuration->getParameter('azine_social_bar_linked_in_company_id'));
        self::assertSame('http://google.plus.profile.url.com', $this->configuration->getParameter('azine_social_bar_google_plus_profile_url'));
        self::assertSame('acme', $this->configuration->getParameter('azine_social_bar_twitter_username'));
    }

    private function getMinimalConfig(): array
    {
        return Yaml::parse('') ?? [];
    }

    private function getFullConfigWithValues(): array
    {
        $yaml = <<<'EOF'
fb_profile_url:       http://fb.profile.url.com
google_plus_profile_url:  http://google.plus.profile.url.com
xing_profile_url:     http://xing.profile.url.com
linked_in_company_id:  1234567890
twitter_username:     acme
EOF;

        return Yaml::parse($yaml);
    }
}
