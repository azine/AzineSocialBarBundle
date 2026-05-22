<?php

namespace Azine\SocialBarBundle\Templating;

use Twig\Environment;

class SocialBarHelper
{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function socialButtons(array $parameters): string
    {
        return $this->twig->render('@AzineSocialBar/socialButtons.html.twig', $parameters);
    }

    public function facebookButton(array $parameters): string
    {
        return $this->twig->render('@AzineSocialBar/facebookButton.html.twig', $parameters);
    }

    public function twitterButton(array $parameters): string
    {
        return $this->twig->render('@AzineSocialBar/twitterButton.html.twig', $parameters);
    }

    public function googlePlusButton(array $parameters): string
    {
        return $this->twig->render('@AzineSocialBar/googlePlusButton.html.twig', $parameters);
    }

    public function linkedInButton(array $parameters): string
    {
        return $this->twig->render('@AzineSocialBar/linkedInButton.html.twig', $parameters);
    }

    public function xingButton(array $parameters): string
    {
        return $this->twig->render('@AzineSocialBar/xingButton.html.twig', $parameters);
    }
}
