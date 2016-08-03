<?php
include "wechat.class.php";
include "config.php";
include "processor.php";

$options = array(
		'token'          => TOKEN,
		'encodingaeskey' => ENCODINGAESKEY,
		'appid'          => APPID,
		'appsecret'      => APPSECRET
	);
$weObj = new Wechat( $options );
// $weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败

// NOTE: MUST invoke $weObj->getRev() before any other weObj functions
// it trans wechat xml message to weObj member value 
$weObj->getRev();
$openid = $weObj->getRevFrom();

switch($weObj->getRevType()) {
	case Wechat::MSGTYPE_TEXT:
		handleMsgText( $weObj );
		break;

	case Wechat::MSGTYPE_EVENT:
		handleMsgEvent( $weObj );
		break;

	default:
		break;
}

function handleMsgText( $weObj ) {
	if (function_exists('onQWCMsgText')) {
		$text = $weObj->getRevContent();
		onQWCMsgText( $weObj, $text );
	}
}

function handleMsgEvent( $weObj ) {
	$object = $weObj->getRevEvent();
	$event = $object["event"];

	switch($event) {
		case Wechat::EVENT_MENU_CLICK:
			if (function_exists('onQWCMenuClick')) {
				$key = $object["key"];
				onQWCMenuClick( $weObj, $key );
			}
			break;

		case Wechat::EVENT_SUBSCRIBE:
			if (function_exists('onQWCSubscribe')) {
				onQWCSubscribe( $weObj, $openid );
			}
			break;

		case Wechat::EVENT_UNSUBSCRIBE:
			if (function_exists('onQWCUnsubscribe')) {
				onQWCUnsubscribe( $weObj, $openid );
			}
			break;

		case Wechat::EVENT_SCAN:
			if (function_exists('onQWCScan')) {
				onQWCScan( $weObj, $openid );
			}
			break;

		default:
			break;
	}
}

