<?php

namespace Azine\SocialBarBundle\Tests\Templating;

use Azine\SocialBarBundle\Templating\SocialBarHelper;
use Azine\SocialBarBundle\Templating\SocialBarTwigExtension;
use PHPUnit\Framework\TestCase;

class SocialBarTwigExtensionTest extends TestCase
{
    public function testGetName(): void
    {
        $helperMock = $this->createMock(SocialBarHelper::class);
        $socialBarExt = new SocialBarTwigExtension($helperMock);

        self::assertSame('azine_social_bar', $socialBarExt->getName());
    }

    public function testGetFunctions(): void
    {
        $helperMock = $this->createMock(SocialBarHelper::class);
        $socialBarExt = new SocialBarTwigExtension($helperMock);
        $functions = $socialBarExt->getFunctions();

        self::assertCount(6, $functions);
        self::assertArrayHasKey('socialButtons', $functions);
        self::assertArrayHasKey('facebookButton', $functions);
        self::assertArrayHasKey('twitterButton', $functions);
        self::assertArrayHasKey('googlePlusButton', $functions);
        self::assertArrayHasKey('xingButton', $functions);
        self::assertArrayHasKey('linkedInButton', $functions);
    }

    public function testGetSocialButtonsAllPluginsShare(): void
    {
        $helperMock = $this->createMock(SocialBarHelper::class);
        $expected = [
            'facebook' => [],
            'twitter' => [],
            'googleplus' => [],
            'xing' => [],
            'linkedin' => [],
            'action' => 'share',
            'width' => 130,
            'height' => 20,
        ];

        $helperMock->expects(self::once())->method('socialButtons')->with($expected)->willReturn('');
        $socialBarExt = new SocialBarTwigExtension($helperMock);
        $socialBarExt->getSocialButtons([], 'share');
    }

    public function testGetFacebookButtonFollow(): void
    {
        $helperMock = $this->createMock(SocialBarHelper::class);
        $expected = [
            'locale' => 'en_US',
            'send' => false,
            'width' => 130,
            'showFaces' => false,
            'layout' => 'button_count',
            'url' => 'http://some.fb.url',
            'action' => 'fb-follow',
        ];

        $helperMock->expects(self::once())->method('facebookButton')->with($expected)->willReturn('');
        $socialBarExt = new SocialBarTwigExtension($helperMock);
        $socialBarExt->getFacebookButton(['fbProfileUrl' => 'http://some.fb.url'], 'follow');
    }

    public function testGetTwitterButtonShare(): void
    {
        $helperMock = $this->createMock(SocialBarHelper::class);
        $expected = [
            'url' => 'http://some.url',
            'tag' => 'someTag',
            'locale' => 'en',
            'message' => 'I want to share that page with you',
            'text' => 'Tweet',
            'via' => 'azine-team',
            'actionClass' => 'twitter-share-button',
            'action' => 'share',
        ];

        $helperMock->expects(self::once())->method('twitterButton')->with($expected)->willReturn('');
        $socialBarExt = new SocialBarTwigExtension($helperMock);
        $socialBarExt->getTwitterButton(['url' => 'http://some.url', 'tag' => 'someTag', 'twitterUsername' => 'azine-team'], 'share');
    }

    public function testInvalidActionThrowsException(): void
    {
        $helperMock = $this->createMock(SocialBarHelper::class);
        $socialBarExt = new SocialBarTwigExtension($helperMock);

        $this->expectException(\InvalidArgumentException::class);
        $socialBarExt->getXingButton([], 'invalid');
    }
}
