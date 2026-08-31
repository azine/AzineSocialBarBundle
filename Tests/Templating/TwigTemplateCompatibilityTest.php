<?php

declare(strict_types=1);

namespace Azine\SocialBarBundle\Tests\Templating;

use Azine\SocialBarBundle\Templating\SocialBarHelper;
use Azine\SocialBarBundle\Templating\SocialBarTwigExtension;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigTemplateCompatibilityTest extends TestCase
{
    public function testEveryBundleTemplateCompilesWithTwig3(): void
    {
        $twig = $this->twig();

        foreach (glob(__DIR__.'/../../Resources/views/*.html.twig') ?: [] as $file) {
            $twig->load('@AzineSocialBar/'.basename($file));
        }

        self::addToAssertionCount(1);
    }

    public function testTwitterShareTemplateRendersWithModernSameAsSyntax(): void
    {
        $html = $this->twig()->render('@AzineSocialBar/twitterButton.html.twig', [
            'url' => 'https://example.test/article',
            'action' => 'share',
            'actionClass' => 'twitter-share-button',
            'message' => 'Share me',
            'locale' => 'en',
            'via' => false,
            'tag' => false,
            'text' => 'Tweet',
        ]);

        self::assertStringContainsString('https://twitter.com/share', $html);
        self::assertStringContainsString('data-url="https://example.test/article"', $html);
        self::assertStringNotContainsString('data-via=', $html);
        self::assertStringNotContainsString('data-hashtags=', $html);
    }

    private function twig(): Environment
    {
        $loader = new FilesystemLoader();
        $loader->addPath(__DIR__.'/../../Resources/views', 'AzineSocialBar');
        $twig = new Environment($loader, ['strict_variables' => true]);
        $helper = new SocialBarHelper($twig);
        $twig->addExtension(new SocialBarTwigExtension($helper));

        return $twig;
    }
}
