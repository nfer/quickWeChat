<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>查看永久素材列表</title>
	<style type="text/css">
		a {
			display: inline !important;
			padding: 10px !important;
		}
		img {
			display: inline !important;
			height: 100px;
			width: 100px;
		}
		.type-list li {
			padding: 10px 0;
		}
		.item-list li {
			padding: 5px 0;
		}
	</style>
</head>
<body>

<?php
include "wechat.class.php";
include "config.php";

$options = array(
		'token'          => TOKEN,
		'encodingaeskey' => ENCODINGAESKEY,
		'appid'          => APPID,
		'appsecret'      => APPSECRET
	);
$weObj = new Wechat($options);
$count = $weObj->getForeverCount();
echo "<ul class='type-list'>";
echo "	<li>语音总数量(".$count['voice_count']."): ".outputPageList('voice', $count['voice_count'])."</li>";
echo "	<li>视频总数量(".$count['video_count']."): ".outputPageList('video', $count['video_count'])."</li>";
echo "	<li>图片总数量(".$count['image_count']."): ".outputPageList('image', $count['image_count'])."</li>";
echo "	<li>图文总数量(".$count['news_count']."): ".outputPageList('news', $count['news_count'])."</li>";
echo "</ul>";

if( isset($_GET['type'], $_GET['page']) ) {
	$page = $_GET['page'];
	outputForeverList($_GET['type'], $page*20, 20);
}

function outputPageList($type, $count) {
	if ($count == 0) return;

	$output = '';
	$page_len = floor(($count-1) / 20)+1;
	for ($i=0; $i < $page_len; $i++) {
		$output .= "<a href='getForeverList.php?type=$type&page=$i'>".($i+1)."</a>";
	}
	return $output;
}

function outputForeverList($type, $offset, $count) {
	global $weObj;
	$list = $weObj->getForeverList($type, $offset, $count);
	switch ($type) {
		case 'image':
			outputImage($list);
			break;
		case 'news':
			outputNews($list);
			break;

		default:
			var_dump($list);
			break;
	}
}

function outputImage($list) {
	$itemList = $list['item'];
	echo "<ul class='item-list'>";
	foreach ($itemList as $item) {
		$media_id = $item['media_id'];
		$url = $item['url'];
		$title = $item['name'];
		echo "	<li> media_id：$media_id <a href='$url' target='_blank'>链接</a> 名称：$title</li>";
	}
	echo "</ul>";
}

function outputNews($list) {
	$itemList = $list['item'];
	echo "<ul class='item-list'>";
	foreach ($itemList as $item) {
		$media_id = $item['media_id'];
		$url = $item['content']['news_item'][0]['url'];
		$thumb_url = $item['content']['news_item'][0]['thumb_url'];
		$title = $item['content']['news_item'][0]['title'];
		$digest = $item['content']['news_item'][0]['digest'];
		echo "	<li> <a href='$url' target='_blank'>链接</a> <a href='$thumb_url' target='_blank'>封面</a> 标题：$title <br>描述：$digest</li>";
	}
	echo "</ul>";
}

?>
</body>
</html>