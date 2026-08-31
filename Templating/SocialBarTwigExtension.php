<?php

namespace Azine\SocialBarBundle\Templating;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SocialBarTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly SocialBarHelper $socialBarHelper,
        private readonly string $facebookProfileUrl = '',
        private readonly string $xingProfileUrl = '',
        private readonly string $linkedInCompanyId = '',
        private readonly string $googlePlusProfileUrl = '',
        private readonly string $twitterUsername = '',
    ) {
    }

    public function getName(): string
    {
        return 'azine_social_bar';
    }

    public function getFunctions(): array
    {
        return [
            'socialButtons' => new TwigFunction('socialButtons', [$this, 'getSocialButtons'], ['is_safe' => ['html']]),
            'facebookButton' => new TwigFunction('facebookButton', [$this, 'getFacebookButton'], ['is_safe' => ['html']]),
            'twitterButton' => new TwigFunction('twitterButton', [$this, 'getTwitterButton'], ['is_safe' => ['html']]),
            'googlePlusButton' => new TwigFunction('googlePlusButton', [$this, 'getGooglePlusButton'], ['is_safe' => ['html']]),
            'xingButton' => new TwigFunction('xingButton', [$this, 'getXingButton'], ['is_safe' => ['html']]),
            'linkedInButton' => new TwigFunction('linkedInButton', [$this, 'getLinkedInButton'], ['is_safe' => ['html']]),
        ];
    }

    public function getSocialButtons(array $parameters = [], string $action = 'share'): string
    {
        $commonParameters = $parameters;
        $renderParameters = [];

        foreach (['facebook', 'twitter', 'googleplus', 'xing', 'linkedin'] as $network) {
            unset($commonParameters[$network]);
        }

        foreach (['facebook', 'twitter', 'googleplus', 'xing', 'linkedin'] as $network) {
            if (!array_key_exists($network, $parameters)) {
                $renderParameters[$network] = $commonParameters;
            } elseif (is_array($parameters[$network])) {
                $renderParameters[$network] = array_merge($commonParameters, $parameters[$network]);
            } else {
                $renderParameters[$network] = false;
            }
        }

        $renderParameters['action'] = $action;
        $renderParameters['width'] = 130;
        $renderParameters['height'] = 20;

        return $this->socialBarHelper->socialButtons($renderParameters);
    }

    public function getFacebookButton(array $parameters = [], string $action = 'share'): string
    {
        $parameters += [
            'locale' => 'en_US',
            'send' => false,
            'width' => 130,
            'showFaces' => false,
            'layout' => 'button_count',
        ];

        if ('share' === $action) {
            $parameters['url'] ??= null;
            $parameters['action'] = 'fb-like';
        } elseif ('follow' === $action) {
            $parameters['url'] = $parameters['fbProfileUrl'] ?? $this->facebookProfileUrl;
            $parameters['action'] = 'fb-follow';
        } else {
            throw new \InvalidArgumentException("Unknown social action. Only 'share' and 'follow' are supported.");
        }

        unset($parameters['fbProfileUrl']);

        return $this->socialBarHelper->facebookButton($parameters);
    }

    public function getTwitterButton(array $parameters = [], string $action = 'share'): string
    {
        $twitterUsername = $parameters['twitterUsername'] ?? $this->twitterUsername;
        $parameters += [
            'url' => $parameters['url'] ?? null,
            'locale' => 'en',
            'message' => 'I want to share that page with you',
            'text' => 'Tweet',
            'via' => $twitterUsername,
            'tag' => $parameters['tag'] ?? $twitterUsername,
        ];

        if ('share' === $action) {
            $parameters['actionClass'] = 'twitter-share-button';
            $parameters['action'] = 'share';
        } elseif ('follow' === $action) {
            $parameters['actionClass'] = 'twitter-follow-button';
            $parameters['action'] = $twitterUsername;
        } else {
            throw new \InvalidArgumentException("Unknown social action. Only 'share' and 'follow' are supported.");
        }

        unset($parameters['twitterUsername']);

        return $this->socialBarHelper->twitterButton($parameters);
    }

    public function getGooglePlusButton(array $parameters = [], string $action = 'share'): string
    {
        $parameters += [
            'locale' => 'en',
            'size' => 'medium',
            'annotation' => 'bubble',
            'width' => 130,
            'height' => 20,
        ];

        if ('share' === $action) {
            $parameters['url'] ??= null;
            $parameters['rel'] = 'author';
            $parameters['action'] = 'g-plusone';
        } elseif ('follow' === $action) {
            $parameters['url'] = $parameters['googlePlusProfileUrl'] ?? $this->googlePlusProfileUrl;
            $parameters['rel'] = 'publisher';
            $parameters['action'] = 'g-follow';
        } else {
            throw new \InvalidArgumentException("Unknown social action. Only 'share' and 'follow' are supported.");
        }

        unset($parameters['googlePlusProfileUrl']);

        return $this->socialBarHelper->googlePlusButton($parameters);
    }

    public function getLinkedInButton(array $parameters = [], string $action = 'share'): string
    {
        $parameters += ['locale' => 'en', 'counterLocation' => 'right'];

        if ('share' === $action) {
            $parameters['action'] = 'IN/Share';
            $parameters['url'] ??= null;
        } elseif ('follow' === $action) {
            $parameters['action'] = 'IN/FollowCompany';
            $parameters['companyId'] = $parameters['linkedInCompanyId'] ?? $this->linkedInCompanyId;
        } else {
            throw new \InvalidArgumentException("Unknown social action. Only 'share' and 'follow' are supported.");
        }

        unset($parameters['linkedInCompanyId']);

        return $this->socialBarHelper->linkedInButton($parameters);
    }

    public function getXingButton(array $parameters = [], string $action = 'share'): string
    {
        $parameters += ['locale' => 'en', 'action' => 'XING/Share', 'counterLocation' => 'right'];

        if ('share' === $action) {
            $parameters['url'] ??= null;
        } elseif ('follow' === $action) {
            $parameters['url'] = $parameters['xingProfileUrl'] ?? $this->xingProfileUrl;
        } else {
            throw new \InvalidArgumentException("Unknown social action. Only 'share' and 'follow' are supported.");
        }

        unset($parameters['xingProfileUrl']);

        return $this->socialBarHelper->xingButton($parameters);
    }
}
