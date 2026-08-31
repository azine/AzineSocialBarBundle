AzineSocialBarBundle
====================

Symfony bundle to easily create a social bar in Twig templates.

## Requirements

- PHP 8.5+
- Symfony components 7.4+
- Twig 3+

## Installation

```bash
composer require azine/socialbar-bundle
```

## Configuration Options

To render social buttons with references to your account(s), configure:

```yaml
# config/packages/azine_social_bar.yaml
azine_social_bar:
    fb_profile_url: ''
    google_plus_profile_url: ''
    xing_profile_url: ''
    linked_in_company_id: ''
    twitter_username: ''
```

## Running tests locally

```bash
composer update
vendor/bin/phpunit -c phpunit.xml.dist
```

## CI

GitHub Actions runs composer validation and PHPUnit on every push and pull request.

## Upgrade notes

- Minimum PHP is now `^8.5`.
- Symfony dependencies now target `^7.4` component packages.
- Legacy templating integration was replaced with Twig 3 `Environment` rendering.
- Travis CI is deprecated in favor of GitHub Actions.
