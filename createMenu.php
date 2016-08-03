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

if (function_exists('getQWCMenuArr')) {
	$menu = getQWCMenuArr( $weObj );
	$result = $weObj->createMenu( $menu );
	if ($result)
		echo "createMenu OK<br/>";
	else
		echo "createMenu failed<br/>";

	Header("Content-Type:text/html;charset=utf-8");
	echo "<pre>".print_r( $menu, true )."</pre>";
}
else {
	echo "Please define and implement getQWCMenuArr() function.";
}
