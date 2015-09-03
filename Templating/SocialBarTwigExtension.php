<?php
namespace Azine\SocialBarBundle\Templating;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SocialBarTwigExtension extends \Twig_Extension
{
    protected $container;
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    public function initRuntime(\Twig_Environment $environment){
        $this->twig = $environment;
    }

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'azine_social_bar';
    }

    public function getFunctions()
    {
        $functions = array();
        $functions['socialButtons'   ] = new \Twig_SimpleFunction('socialButtons'   , array($this,'getSocialButtons'), array('is_safe' => array('html')));
        $functions['facebookButton'  ] = new \Twig_SimpleFunction('facebookButton'  , array($this,'getFacebookButton'), array('is_safe' => array('html')));
        $functions['twitterButton'   ] = new \Twig_SimpleFunction('twitterButton'   , array($this,'getTwitterButton'), array('is_safe' => array('html')));
        $functions['googlePlusButton'] = new \Twig_SimpleFunction('googlePlusButton', array($this,'getGooglePlusButton'), array('is_safe' => array('html')));
        $functions['xingButton'      ] = new \Twig_SimpleFunction('xingButton'      , array($this,'getXingButton'), array('is_safe' => array('html')));
        $functions['linkedInButton'  ] = new \Twig_SimpleFunction('linkedInButton'  , array($this,'getLinkedInButton'), array('is_safe' => array('html')));
        return $functions;
    }

    /**
     * Get all the buttons in one row
     * @param array  $parameters
     * @param string $action
     */
    public function getSocialButtons(array $parameters = array(), $action = "share")
    {
        $commonParams = $parameters;
        $render_parameters = array();
        if(array_key_exists('facebook', $commonParams)) unset($commonParams['facebook']);
        if(array_key_exists('twitter', $commonParams)) unset($commonParams['twitter']);
        if(array_key_exists('googleplus', $commonParams)) unset($commonParams['googleplus']);
        if(array_key_exists('xing', $commonParams)) unset($commonParams['xing']);
        if(array_key_exists('linkedin', $commonParams)) unset($commonParams['linkedin']);

        // no parameters were defined, keeps default values
        if (!array_key_exists('facebook', $parameters)) {
            $render_parameters['facebook'] = $parameters;

            // parameters are defined, overrides default values
        } elseif (is_array($parameters['facebook'])) {
            $render_parameters['facebook'] = array_merge($commonParams, $parameters['facebook']);

        // the button is not displayed
        } else {
            $render_parameters['facebook'] = false;
        }

        if (!array_key_exists('twitter', $parameters)) {
            $render_parameters['twitter'] = $parameters;

        } elseif (is_array($parameters['twitter'])) {
            $render_parameters['twitter'] = array_merge($commonParams, $parameters['twitter']);

        } else {
            $render_parameters['twitter'] = false;
        }

        if (!array_key_exists('googleplus', $parameters)) {
            $render_parameters['googleplus'] = $parameters;

        } elseif (is_array($parameters['googleplus'])) {
            $render_parameters['googleplus'] = array_merge($commonParams, $parameters['googleplus']);

        } else {
            $render_parameters['googleplus'] = false;
        }

        if (!array_key_exists('xing', $parameters)) {
            $render_parameters['xing'] = $parameters;

        } elseif (is_array($parameters['xing'])) {
            $render_parameters['xing'] = array_merge($commonParams, $parameters['xing']);

        } else {
            $render_parameters['xing'] = false;
        }


        if (!array_key_exists('linkedin', $parameters)) {
            $render_parameters['linkedin'] = $parameters;

        } elseif (is_array($parameters['linkedin'])) {
            $render_parameters['linkedin'] = array_merge($commonParams, $parameters['linkedin']);

        } else {
            $render_parameters['linkedin'] = false;
        }

        $render_parameters['action'] = $action;
        $render_parameters['width'] = 130;
        $render_parameters['height'] = 20;


     // get the helper service and display the template
        return $this->container->get('azine.socialBarHelper')->socialButtons($render_parameters);
    }

    /**
     * Render the html for the facebook like button
     * => https://developers.facebook.com/docs/reference/plugins/like/
     * @param array $parameters
     */
    public function getFacebookButton($parameters = array(), $action = "share")
    {
        // default values, you can override the values by setting them
        $parameters = $parameters + array(
            'locale' => 'en_US',
            'send' => false,
            'width' => 130,
            'showFaces' => false,
            'layout' => 'button_count',
            );

        if ($action == "share") {
            $parameters['url'] = array_key_exists('url', $parameters) ? $parameters['url'] : null;
            $parameters['action'] = 'fb-like';

        } elseif ($action == "follow") {
            $parameters['url'] = $this->container->getParameter("azine_social_bar_fb_profile_url");
            $parameters['action'] = "fb-follow";

        } else {
            throw new \Exception("Unknown social action. Only 'share' and 'follow' are known at the moment.");
        }

        return $this->container->get('azine.socialBarHelper')->facebookButton($parameters);
    }

    /**
     * Render the html for the twitter button
     * =>
     * @param array $parameters
     */
    public function getTwitterButton($parameters = array(), $action = "share")
    {
        $parameters = $parameters + array(
            'url' => array_key_exists('url', $parameters) ? $parameters['url'] : null,
            'locale' => 'en',
            'message' => 'I want to share that page with you',
            'text' => 'Tweet',
            'via' => $this->container->getParameter("azine_social_bar_twitter_username"),
            'tag' => array_key_exists('tag', $parameters) ? $parameters['tag'] : $this->container->getParameter("azine_social_bar_twitter_username"),
            );
        if ($action == "share") {
            $parameters['actionClass'] = "twitter-share-button";
            $parameters['action'] = "share";

        } elseif ($action == "follow") {
            $parameters['actionClass'] = "twitter-follow-button";
            $parameters['action'] = $this->container->getParameter("azine_social_bar_twitter_username");

        } else {
            throw new \Exception("Unknown social action. Only 'share' and 'follow' are known at the moment.");
        }

        return $this->container->get('azine.socialBarHelper')->twitterButton($parameters);
    }

    /**
     * Render the html for the Google+ button
     * =>
     * @param array $parameters
     */
    public function getGooglePlusButton($parameters = array(), $action = "share")
    {
        $parameters = $parameters + array(
            'locale' => 'en',
            'size' => 'medium',
            'annotation' => 'bubble',
            'width' => 130,
            'height' => 20,
        );

        if ($action == "share") {
            $parameters['url'] = array_key_exists('url', $parameters) ? $parameters['url'] : null;
            $parameters['rel'] = 'author';
            $parameters['action'] = 'g-plusone';

        } elseif ($action == "follow") {
            $parameters['url'] = $this->container->getParameter("azine_social_bar_google_plus_profile_url");
            $parameters['rel'] = "publisher";
            $parameters['action'] = "g-follow";

        } else {
            throw new \Exception("Unknown social action. Only 'share' and 'follow' are known at the moment.");
        }

        return $this->container->get('azine.socialBarHelper')->googlePlusButton($parameters);
    }

    public function getLinkedInButton($parameters = array(), $action = "share")
    {
        $parameters = $parameters + array(
            'locale' => 'en',
            'counterLocation' => 'right',
        );

        if ($action == "share") {
            $parameters['action'] = 'IN/Share';
            $parameters['url'] = array_key_exists('url', $parameters) ? $parameters['url'] : null;

        } elseif ($action == "follow") {
            $parameters['action'] = 'IN/FollowCompany';
            $parameters['companyId'] = $this->container->getParameter("azine_social_bar_linked_in_company_id");

        } else {
            throw new \Exception("Unknown social action. Only 'share' and 'follow' are known at the moment.");
        }

        return $this->container->get('azine.socialBarHelper')->linkedInButton($parameters);
    }

    public function getXingButton($parameters = array(), $action = "share")
    {
        $parameters = $parameters + array(
            'locale' => 'en',
            'action' => 'XING/Share',
            'counterLocation' => 'right',
        );

        if ($action == "share") {
            $parameters['url'] = array_key_exists('url', $parameters) ? $parameters['url'] : null;
        } elseif ($action == "follow") {
            $parameters['url'] = $this->container->getParameter("azine_social_bar_xing_profile_url");
        } else {
            throw new \Exception("Unknown social action. Only 'share' and 'follow' are known at the moment.");
        }

        return $this->container->get('azine.socialBarHelper')->xingButton($parameters);
    }
}
