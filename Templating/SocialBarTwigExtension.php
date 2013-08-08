<?php
namespace Azine\SocialBarBundle\Templating;

class SocialBarTwigExtension extends \Twig_Extension{

    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'azine_social_bar';
    }

    public function getFunctions()
    {
      return array(
        'socialButtons' => new \Twig_Function_Method($this, 'getSocialButtons' ,array('is_safe' => array('html'))),
        'facebookButton' => new \Twig_Function_Method($this, 'getFacebookLikeButton' ,array('is_safe' => array('html'))),
        'twitterButton' => new \Twig_Function_Method($this, 'getTwitterButton' ,array('is_safe' => array('html'))),
        'googlePlusButton' => new \Twig_Function_Method($this, 'getGooglePlusButton' ,array('is_safe' => array('html'))),
        'xingButton' => new \Twig_Function_Method($this, 'getXingButton' ,array('is_safe' => array('html'))),
        'linkedInButton' => new \Twig_Function_Method($this, 'getLinkedInButton' ,array('is_safe' => array('html'))),
      );
    }

    /**
     * Get all the buttons in one row
     * @param unknown_type $parameters
     */
    public function getSocialButtons($parameters = array())
    {
      // no parameters were defined, keeps default values
      if (!array_key_exists('facebook', $parameters)){
        $render_parameters['facebook'] = array();
      // parameters are defined, overrides default values
      }else if(is_array($parameters['facebook'])){
        $render_parameters['facebook'] = $parameters['facebook'];
      // the button is not displayed
      }else{
        $render_parameters['facebook'] = false;
      }

      if (!array_key_exists('twitter', $parameters)){
        $render_parameters['twitter'] = array();
      }else if(is_array($parameters['twitter'])){
        $render_parameters['twitter'] = $parameters['twitter'];
      }else{
        $render_parameters['twitter'] = false;
      }

      if (!array_key_exists('googleplus', $parameters)){
        $render_parameters['googleplus'] = array();
      }else if(is_array($parameters['googleplus'])){
        $render_parameters['googleplus'] = $parameters['googleplus'];
      }else{
        $render_parameters['googleplus'] = false;
      }

      if (!array_key_exists('xing', $parameters)){
      	$render_parameters['xing'] = array();
      }else if(is_array($parameters['xing'])){
      	$render_parameters['xing'] = $parameters['xing'];
      }else{
      	$render_parameters['xing'] = false;
      }


      if (!array_key_exists('linkedin', $parameters)){
      	$render_parameters['linkedin'] = array();
      }else if(is_array($parameters['linkedin'])){
      	$render_parameters['linkedin'] = $parameters['linkedin'];
      }else{
      	$render_parameters['linkedin'] = false;
      }

     // get the helper service and display the template
      return $this->container->get('azine.socialBarHelper')->socialButtons($render_parameters);
    }

    /**
     * Render the html for the facebook like button
	 * => https://developers.facebook.com/docs/reference/plugins/like/
     * @param array $parameters
     */
    public function getFacebookLikeButton($parameters = array())
    {
       // default values, you can override the values by setting them
       $parameters = $parameters + array(
            'url' => null,
            'locale' => 'en_US',
            'send' => false,
            'width' => 300,
            'showFaces' => false,
            'layout' => 'button_count',
        );

       return $this->container->get('azine.socialBarHelper')->facebookButton($parameters);
    }

    /**
     * Render the html for the twitter button
	 * =>
     * @param array $parameters
     */
    public function getTwitterButton($parameters = array())
    {
       $parameters = $parameters + array(
            'url' => null,
            'locale' => 'en',
            'message' => 'I want to share that page with you',
            'text' => 'Tweet',
            'via' => 'The Acme team',
            'tag' => 'ttot',
        );


       return $this->container->get('azine.socialBarHelper')->twitterButton($parameters);
    }

    /**
     * Render the html for the Google+ button
	 * =>
     * @param array $parameters
     */
    public function getGooglePlusButton($parameters = array())
    {
       $parameters = $parameters + array(
            'url' => null,
            'locale' => 'en',
            'size' => 'medium',
            'annotation' => 'bubble',
            'width' => '300',
			'height' => '20',
       		'rel'	=> 'author',
       		'action' => 'g-plusone', // g-follow
        );

       return $this->container->get('azine.socialBarHelper')->googlePlusButton($parameters);
    }

    public function getLinkedInButton($parameters = array()){
    	$parameters = $parameters + array(
			'action'  => 'IN/FollowCompany',
			'locale' => 'en',
			'companyId' => 2811461,
    		'counterLocation' => 'right', // top
    	);
    	return $this->container->get('azine.socialBarHelper')->linkedInButton($parameters);
    }

    public function getXingButton($parameters = array()){
    	$parameters = $parameters + array(
            'locale' => 'en',
    		'action' => 'XING/Share',
    		'counterLocation' => 'right', // top
    	);
    	return $this->container->get('azine.socialBarHelper')->xingButton($parameters);
    }
}