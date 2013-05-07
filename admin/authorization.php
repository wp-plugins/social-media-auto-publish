<?php

$app_id = get_option('xyz_smap_application_id');
$app_secret = get_option('xyz_smap_application_secret');
$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=1');
$lnredirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=3');

//$redirecturl=trailingslashit($redirecturl);
//$my_url =  $redirecturl."/";
$my_url=urlencode($redirecturl);

session_start();
$code="";
if(isset($_REQUEST['code']))
$code = $_REQUEST["code"];

if(isset($_POST['fb_auth']))
{

	// $appid=get_option('xyz_smap_application_id');
	//$appsecret=get_option('xyz_smap_application_secret');



	//if(empty($code)) {
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
		
		$dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
		. $app_id . "&redirect_uri=" . $my_url . "&state="
		. $_SESSION['state'] . "&scope=read_stream,publish_stream,offline_access,manage_pages";

		header("Location: " . $dialog_url);
	//}
}


if(isset($_SESSION['state']) && isset($_REQUEST['state']) && ($_SESSION['state'] === $_REQUEST['state']) && get_option("xyz_smap_af")==1) {
	
	$token_url = "https://graph.facebook.com/oauth/access_token?"
	. "client_id=" . $app_id . "&redirect_uri=" . $my_url
	. "&client_secret=" . $app_secret . "&code=" . $code;

	//$response = file_get_contents($token_url);
	$params = null;$access_token="";
	$response = wp_remote_get($token_url);
	
	if(is_array($response))
	{
		if(isset($response['body']))
		{
			parse_str($response['body'], $params);
			if(isset($params['access_token']))
			$access_token = $params['access_token'];
		}
	}
	if($access_token!="")
	{
		update_option('xyz_smap_fb_token',$access_token);
		update_option('xyz_smap_af',0);
	}
}
else {
	//echo("The state does not match. You may be a victim of CSRF.");
}


if(isset($_POST['lnauth']))
{
	
	$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=3');
	
	// $redirecturl=trailingslashit($redirecturl);
	$lnappikey=get_option('xyz_smap_lnapikey');
	$lnapisecret=get_option('xyz_smap_lnapisecret');
	
	# First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
	$API_CONFIG = array(
	'appKey'       => $lnappikey,
	'appSecret'    => $lnapisecret,
	'callbackUrl'  => $redirecturl
	);

	$OBJ_linkedin = new LinkedIn($API_CONFIG);
	$response = $OBJ_linkedin->retrieveTokenRequest();//print_r($response);die;
	
	if(isset($response['error']))
	{
		//echo $response['error'];
			
		header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=1'));
		exit();
	}
	
	
	//$OBJ_linkedin->setTokenAccess($response['linkedin']);

	$lnoathtoken=$response['linkedin']['oauth_token'];
	$lnoathseret=$response['linkedin']['oauth_token_secret'];
	

	# Now we retrieve a request token. It will be set as $linkedin->request_token

	update_option('xyz_smap_lnoauth_token', $lnoathtoken);
	update_option('xyz_smap_lnoauth_secret',$lnoathseret);
	header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
	
	die;
	

}

if(isset($_GET['auth']) && $_GET['auth']==3 && get_option("xyz_smap_lnaf")==1)
{
	if(isset($_GET['auth_problem']))
		break;
	$lnoathtoken=get_option('xyz_smap_lnoauth_token');
	$lnoathseret=get_option('xyz_smap_lnoauth_secret');

	 
	$lnappikey=get_option('xyz_smap_lnapikey');
	$lnapisecret=get_option('xyz_smap_lnapisecret');

	$lnoauth_verifier=$_GET['oauth_verifier'];


	update_option('xyz_smap_lnoauth_verifier',$lnoauth_verifier);

	$API_CONFIG = array(
			'appKey'       => $lnappikey,
			'appSecret'    => $lnapisecret,
			'callbackUrl'  => $lnredirecturl
	);

	$OBJ_linkedin = new LinkedIn($API_CONFIG);
	$response = $OBJ_linkedin->retrieveTokenAccess($lnoathtoken, $lnoathseret, $lnoauth_verifier);


	# Now we retrieve a request token. It will be set as $linkedin->request_token
	update_option('xyz_smap_application_lnarray', $response['linkedin']);	
	update_option('xyz_smap_lnaf',0);

}

?>