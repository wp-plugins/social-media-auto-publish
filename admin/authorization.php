<?php

$app_id = get_option('xyz_smap_application_id');
$app_secret = get_option('xyz_smap_application_secret');
$redirecturl=admin_url('admin.php?page=social-media-auto-publish-settings&auth=1');
//$redirecturl=trailingslashit($redirecturl);
$my_url =  $redirecturl."/";

session_start();
$code="";
if(isset($_REQUEST['code']))
$code = $_REQUEST["code"];

if(isset($_POST['fb_auth']))
{

	// $appid=get_option('xyz_smap_application_id');
	//$appsecret=get_option('xyz_smap_application_secret');



	if(empty($code)) {
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
		$dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
		. $app_id . "&redirect_uri=" . $my_url . "&state="
		. $_SESSION['state'] . "&scope=read_stream,publish_stream,offline_access,manage_pages";

		header("Location: " . $dialog_url);
	}
}


if(isset($_SESSION['state']) && isset($_REQUEST['state']) && ($_SESSION['state'] === $_REQUEST['state']) && get_option("xyz_smap_af")==1) {
	$token_url = "https://graph.facebook.com/oauth/access_token?"
	. "client_id=" . $app_id . "&redirect_uri=" . $my_url
	. "&client_secret=" . $app_secret . "&code=" . $code;

	$response = file_get_contents($token_url);
	$params = null;
	parse_str($response, $params);
	$access_token = $params['access_token'];
	update_option('xyz_smap_fb_token',$access_token);
	update_option('xyz_smap_af',0);
}
else {
	//echo("The state does not match. You may be a victim of CSRF.");
}


?>