<?php
include "wechat.class.php";
include "config.php";

$options = array(
		'token'          => TOKEN,
		'encodingaeskey' => ENCODINGAESKEY,
		'appid'          => APPID,
		'appsecret'      => APPSECRET
	);
$weObj = new Wechat( $options );

$oauthAccessToken = $weObj->getOauthAccessToken();
$openid = isset( $oauthAccessToken['openid'] ) ? $oauthAccessToken['openid'] : null;

if ( !$openid ) {
	echo "Please Open in Wechat App.";
	exit();
}

include "processor.php";
if (function_exists('onQWCRedircted')) {
	$state = isset( $_GET['state'] ) ? $_GET['state'] : '';
	onQWCRedircted( $openid, $state );
}
