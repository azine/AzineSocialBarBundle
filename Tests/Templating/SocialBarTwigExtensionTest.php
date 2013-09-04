<?php
namespace Azine\SocialBarBundle\Tests\Templating;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Azine\SocialBarBundle\Templating\SocialBarTwigExtension;

class SocialBarTwigExtensionTest extends \PHPUnit_Framework_TestCase{


	public function testGetName(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$this->assertEquals('azine_social_bar', $socialBarExt->getName());
	}

	public function testGetFunctions(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$functions = $socialBarExt->getFunctions();
		$this->assertEquals(6, sizeof($functions));

		$this->assertArrayHasKey('socialButtons', $functions);
		$this->assertArrayHasKey('facebookButton', $functions);
		$this->assertArrayHasKey('twitterButton', $functions);
		$this->assertArrayHasKey('googlePlusButton', $functions);
		$this->assertArrayHasKey('xingButton', $functions);
		$this->assertArrayHasKey('linkedInButton', $functions);

	}

	public function testGetSocialButtons_all_plugins_share(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'share';
		$inputRenderingParams = array();
		$expectedRenderingParams = array(	'facebook' => array (),
										    'twitter' => array (),
										    'googleplus' => array (),
										    'xing' => array (),
										    'linkedin' => array (),
										    'action' => 'share',
										    'width' => 130,
										    'height' => 20
		);

		$helperMock->expects($this->once())->method("socialButtons")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getSocialButtons($inputRenderingParams, $action);

	}

	public function testGetSocialButtons_no_plugins(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array(	'facebook' => false,
										'twitter' => false,
										'googleplus' => false,
										'xing' => false,
										'linkedin' => false,
									);
		$expectedRenderingParams = array(	'facebook' => false,
											'twitter' => false,
											'googleplus' => false,
											'xing' => false,
											'linkedin' => false,
											'action' => 'follow',
											'width' => 130,
											'height' => 20
										);

		$helperMock->expects($this->once())->method("socialButtons")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getSocialButtons($inputRenderingParams, $action);

	}

	public function testGetSocialButtons_plugins_with_custom_params(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array(	'facebook' => array('someParam' => 123),
										'twitter' => array('someParam' => 456),
										'googleplus' => array('someParam' => 789),
										'xing' => array('someParam' => 098),
										'linkedin' => array('someParam' => 765),
									);
		$expectedRenderingParams = array(	'facebook' => array('someParam' => 123),
											'twitter' => array('someParam' => 456),
											'googleplus' => array('someParam' => 789),
											'xing' => array('someParam' => 098),
											'linkedin' => array('someParam' => 765),
											'action' => 'follow',
											'width' => 130,
											'height' => 20
										);

		$helperMock->expects($this->once())->method("socialButtons")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get", ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->with('azine.socialBarHelper')->will($this->returnValue($helperMock));

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getSocialButtons($inputRenderingParams, $action);

	}

	public function testGetFacebookButton_follow(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array();
		$fbProfileUrl = "http://some.fb.url";
		$expectedRenderingParams = array(	'locale' => 'en_US',
											'send' => false,
											'width' => 130,
											'showFaces' => false,
											'layout' => 'button_count',
											'url' => $fbProfileUrl,
											'action' => 'fb-follow'
										);

		$helperMock->expects($this->once())->method("facebookButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->once())->method("getParameter")->with("azine_social_bar_fb_profile_url")->will($this->returnValue($fbProfileUrl));


 		$socialBarExt = new SocialBarTwigExtension($containerMock);
 		$socialBarExt->getFacebookButton($inputRenderingParams, $action);
	}

	public function testGetFacebookButton_share(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'share';
		$someUrl = "http://some.fb.url";
		$inputRenderingParams = array('url' => $someUrl);
		$expectedRenderingParams = array(	'locale' => 'en_US',
											'send' => false,
											'width' => 130,
											'showFaces' => false,
											'layout' => 'button_count',
											'url' => $someUrl,
											'action' => 'fb-like'
									);

		$helperMock->expects($this->once())->method("facebookButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->never())->method("getParameter");

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getFacebookButton($inputRenderingParams, $action);
	}

	public function testGetTwitterButton_follow(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array();
		$twitterUserName = "azine";
		$expectedRenderingParams = array(	'locale' => 'en',
											'url' => null,
											'action' => $twitterUserName,
											'actionClass' => "twitter-follow-button",
										    'message' => 'I want to share that page with you',
										    'text' => 'Tweet',
										    'via' => 'The Acme team',
										    'tag' => 'ttot',
										);

		$helperMock->expects($this->once())->method("twitterButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->once())->method("getParameter")->with("azine_social_bar_twitter_username")->will($this->returnValue($twitterUserName));


 		$socialBarExt = new SocialBarTwigExtension($containerMock);
 		$socialBarExt->getTwitterButton($inputRenderingParams, $action);
	}

	public function testGetTwitterButton_tweet(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'share';
		$someUrl = "http://some.fb.url";
		$inputRenderingParams = array('url' => $someUrl);
		$expectedRenderingParams = array(	'locale' => 'en',
											'url' => $someUrl,
											'action' => "share",
											'actionClass' => "twitter-share-button",
										    'message' => 'I want to share that page with you',
										    'text' => 'Tweet',
										    'via' => 'The Acme team',
										    'tag' => 'ttot',
										);

		$helperMock->expects($this->once())->method("twitterButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->never())->method("getParameter");

		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getTwitterButton($inputRenderingParams, $action);
	}

 	public function testGetGooglePlusButton_follow(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array();
		$googleProfile = "http://plus.google.com/some/profile/url/76543234567";
		$expectedRenderingParams = array(	'locale' => 'en',
										    'url' => $googleProfile,
										    'action' => 'g-follow',
										    'size' => 'medium',
										    'annotation' => 'bubble',
										    'width' => 130,
										    'height' => 20,
										    'rel' => 'publisher',
										);

		$helperMock->expects($this->once())->method("googlePlusButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->once())->method("getParameter")->with("azine_social_bar_google_plus_profile_url")->will($this->returnValue($googleProfile));


		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getGooglePlusButton($inputRenderingParams, $action);

	}

 	public function testGetGooglePlusButton_plus(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'share';
		$someUrl = "http://some.url.com/76543234567";
		$inputRenderingParams = array('url' => $someUrl);
		$expectedRenderingParams = array(	'locale' => 'en',
										    'url' => $someUrl,
										    'action' => 'g-plusone',
										    'size' => 'medium',
										    'annotation' => 'bubble',
										    'width' => 130,
										    'height' => 20,
										    'rel' => 'author',
										);





		$helperMock->expects($this->once())->method("googlePlusButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->never())->method("getParameter");


		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getGooglePlusButton($inputRenderingParams, $action);

	}

	public function testGetLinkedInButton_follow(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array();
		$companyId = "6543234567";
		$expectedRenderingParams = array(	'locale' => 'en',
										    'companyId' => $companyId,
										    'action' => 'IN/FollowCompany',
										    'counterLocation' => 'right',
										);

		$helperMock->expects($this->once())->method("linkedInButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->once())->method("getParameter")->with("azine_social_bar_linked_in_company_id")->will($this->returnValue($companyId));


		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getLinkedInButton($inputRenderingParams, $action);

 	}

	public function testGetLinkedInButton_share(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'share';
		$someUrl = "http://some.url.com/76543234567";
		$inputRenderingParams = array('url' => $someUrl);
		$expectedRenderingParams = array(	'locale' => 'en',
											'url' => $someUrl,
											'action' => 'IN/Share',
											'counterLocation' => 'right',
									);

		$helperMock->expects($this->once())->method("linkedInButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->never())->method("getParameter");


		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getLinkedInButton($inputRenderingParams, $action);

	}


	public function testGetXingButton_follow(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'follow';
		$inputRenderingParams = array();
		$profileUrl = "http://xing.com/some/profile/url/76543234567";
		$expectedRenderingParams = array(	'locale' => 'en',
										    'url' => $profileUrl,
										    'action' => 'XING/Share',
										    'counterLocation' => 'right',
										);

		$helperMock->expects($this->once())->method("xingButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->once())->method("getParameter")->with("azine_social_bar_xing_profile_url")->will($this->returnValue($profileUrl));


		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getXingButton($inputRenderingParams, $action);

 	}

	public function testGetXingButton_share(){
		$containerMock = $this->getMockBuilder("Symfony\Component\DependencyInjection\ContainerInterface")->getMock();
		$helperMock = $this->getMockBuilder("Azine\SocialBarBundle\Templating\SocialBarHelper")->disableOriginalConstructor()->getMock();

		$action = 'share';
		$someUrl = "http://some.url.com/76543234567";
		$inputRenderingParams = array('url' => $someUrl);
		$expectedRenderingParams = array(	'locale' => 'en',
											'url' => $someUrl,
											'action' => 'XING/Share',
											'counterLocation' => 'right',
									);

		$helperMock->expects($this->once())->method("xingButton")->with($expectedRenderingParams);
		$containerMock->expects($this->once())->method("get")->with('azine.socialBarHelper', ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)->will($this->returnValue($helperMock));
		$containerMock->expects($this->never())->method("getParameter");


		$socialBarExt = new SocialBarTwigExtension($containerMock);
		$socialBarExt->getXingButton($inputRenderingParams, $action);

	}
}