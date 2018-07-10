AzineSocialBarBundle
====================

Symfony2 Bundle to easily create a social bar in your twig templates.

Special thanx to Gregquat who posted a good how to get stared here:

http://obtao.com/blog/2012/11/create-a-social-buttons-bar-for-facebook-twitter-and-google-with-symfony2/

As a lot of code is copied from that page, most of the documentation on how to use it in your twig-templates applies as well.

## Configuration Options

To render social buttons with references to your account(s) you can configure some options in the config as follows:

```
//config.yml
azine_social_bar:

    # the url to you Facebook profile: will be used for the 'url' parameter when showing the 'follow' button
    fb_profile_url: #default = ""

    # the url to your Google+ profile: will be used for the 'url' parameter when showing the 'follow' button
    google_plus_profile_url: #defaults = ""

    # the url to your xing profile: will be used for the 'url' parameter when showing the 'follow' button
    xing_profile_url: #default = ""

    # your profile-id (=> get it here http://developer.linkedin.com/plugins) : will be used for the 'companyId' parameter when showing the 'follow' button
    linked_in_company_id: #default = ""

    # your twitter username: will be used for the 'action' parameter when showing the 'follow' button and also for the 'tag' and 'via' parameters of all twitter buttons 
    twitter_username: #default = ""
```


## Build-Status ec.

[![Build Status](https://travis-ci.org/azine/AzineSocialBarBundle.png)](https://travis-ci.org/azine/AzineSocialBarBundle)
[![Total Downloads](https://poser.pugx.org/azine/socialbar-bundle/downloads.png)](https://packagist.org/packages/azine/socialbar-bundle)
[![Latest Stable Version](https://poser.pugx.org/azine/socialbar-bundle/v/stable.png)](https://packagist.org/packages/azine/socialbar-bundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/azine/AzineSocialBarBundle/badges/quality-score.png?s=cfe1738c2ec1c5bed0916521ff5ad5a7a685104c)](https://scrutinizer-ci.com/g/azine/AzineSocialBarBundle/)
[![Code Coverage](https://scrutinizer-ci.com/g/azine/AzineSocialBarBundle/badges/coverage.png?s=0bd90f54589061f1021010d03b336d2d88043976)](https://scrutinizer-ci.com/g/azine/AzineSocialBarBundle/)
