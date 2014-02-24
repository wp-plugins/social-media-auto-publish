<?php
$app_id = get_option('xyz_smap_application_id');
$app_secret = get_option('xyz_smap_application_secret');
$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=1');
$lnredirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=3');
$my_url=urlencode($redirecturl);

session_start();
$code="";
if(isset($_REQUEST['code']))
$code = $_REQUEST["code"];

if(isset($_POST['fb_auth']))
{
		$xyz_smap_session_state = md5(uniqid(rand(), TRUE));
		setcookie("xyz_smap_session_state",$xyz_smap_session_state,"0","/");
		
		$dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
		. $app_id . "&redirect_uri=" . $my_url . "&state="
		. $xyz_smap_session_state . "&scope=read_stream,publish_stream,offline_access,manage_pages";

		header("Location: " . $dialog_url);
}


if(isset($_COOKIE['xyz_smap_session_state']) && isset($_REQUEST['state']) && ($_COOKIE['xyz_smap_session_state'] === $_REQUEST['state']) && get_option("xyz_smap_af")==1) {
	
	$token_url = "https://graph.facebook.com/oauth/access_token?"
	. "client_id=" . $app_id . "&redirect_uri=" . $my_url
	. "&client_secret=" . $app_secret . "&code=" . $code;

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
	else {
		
		header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=3'));
		exit();
	}
}
else {
	
	//header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=2'));
	//exit();
}


if(isset($_POST['lnauth']))
{
	
	$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=3');
	$lnappikey=get_option('xyz_smap_lnapikey');
	$lnapisecret=get_option('xyz_smap_lnapisecret');
	
	# First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
	$API_CONFIG = array(
	'appKey'       => $lnappikey,
	'appSecret'    => $lnapisecret,
	'callbackUrl'  => $redirecturl
	);

	$OBJ_linkedin = new SMAPLinkedIn($API_CONFIG);
	$response = $OBJ_linkedin->retrieveTokenRequest();
	
	if(isset($response['error']))
	{
		header("Location:".admin_url('admin.php?page=social-media-auto-publish-settings&msg=1'));
		exit();
	}

	$lnoathtoken=$response['linkedin']['oauth_token'];
	$lnoathseret=$response['linkedin']['oauth_token_secret'];
	

	# Now we retrieve a request token. It will be set as $linkedin->request_token

	update_option('xyz_smap_lnoauth_token', $lnoathtoken);
	update_option('xyz_smap_lnoauth_secret',$lnoathseret);
	header('Location: ' . SMAPLinkedIn::_URL_AUTH . $response['linkedin']['oauth_token']);
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

	$OBJ_linkedin = new SMAPLinkedIn($API_CONFIG);
	$response = $OBJ_linkedin->retrieveTokenAccess($lnoathtoken, $lnoathseret, $lnoauth_verifier);

	# Now we retrieve a request token. It will be set as $linkedin->request_token
	update_option('xyz_smap_application_lnarray', $response['linkedin']);	
	update_option('xyz_smap_lnaf',0);

}

?>