<?php

function onQWCMsgText( $weObj, $text ) {
	$weObj->text( $text )->reply();
}

function onQWCMenuClick( $weObj, $openid, $key ) {
	switch ( $key ) {
		case 'key1':
			$weObj->text( 'You Click Key1 Menu.' )->reply();
			break;

		case 'key2':
			$weObj->text( 'You Click Key2 Menu.' )->reply();
			break;

		default:
			break;
	}
}

function onQWCSubscribe( $weObj, $openid ) {
	$weObj->text( 'Hello' )->reply();
}

function onQWCUnsubscribe( $weObj, $openid ) {
}

function onQWCScan( $weObj, $openid ) {
}

function onQWCRedircted( $openid, $state ) {
	switch ($state) {
		case 'state1':
			$url = 'http://YOURDOMAIN/state1';
			break;

		default:
			$url = 'http://YOURDOMAIN/';
			break;
	}
	wp_safe_redirect($url);
}

function getQWCMenuArr( $weObj ) {
	$menu = array(
		'button' => array(
			0 => array(
				'name' => 'MainMenu1',
				'sub_button' => array(
					0 => array(
						'type' => 'view',
						'name' => 'HomePage',
						'url'  => 'http://YOURDOMAIN/',
						),
					1 => array(
						'type' => 'view',
						'name' => 'state1',
						'url'  => $weObj->getOauthRedirect('http://YOURDOMAIN/weixin/getOauthAccessToken.php', 'state1', 'snsapi_base'),
						)
					)
				),
			1 => array(
				'name' => 'MainMenu2',
				'sub_button' => array(
					0 => array(
						'type' => 'click',
						'name' => 'Key1',
						'key'  => 'key1',
						),
					1 => array(
						'type' => 'click',
						'name' => 'Key2',
						'key'  => 'key2',
						)
					)
				)
			)
	);

	return $menu;
}
