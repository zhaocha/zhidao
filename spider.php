<?php
header("Content-type: text/html; charset=utf-8"); 
require_once 'myCurl.class.php';
define('__URL', 'https://zhidao.baidu.com/shop/lottery');

// 获取得到
function getUrl($bduss = ''){
	$luckyToken = getLuckyToken($bduss);
	$url = 'https://zhidao.baidu.com/shop/submit/lottery?type=0&token='.$luckyToken;
	return $url;
}

// 开启抽奖
function lottery($url = '', $bduss = ''){
	$header = array(
		'X-Requested-With:XMLHttpRequest',
		'X-ik-ssl:1',
		'User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36',
		'Referer:https://zhidao.baidu.com/shop/lottery',
		'Cookie:'.$bduss
	);
	$obj = new myCurl();
	$content = $obj -> send($url, $header);
	// if(empty($content['data']['userInfo']['freeChance']) || empty($content['data']['prizeList'][0]['goodsName'])){
	// 	return;
	// }
	$content = json_decode($content, true);
	$user = [ 
		'freeChance' => $content['data']['userInfo']['freeChance'],
		'goodsName' => $content['data']['prizeList'][0]['goodsName']
	];
	return $user;
}

// 获取LuckyToken
function getLuckyToken($bduss = ''){
	$obj = new myCurl();
	$cookie = 'Cookie:'.$bduss;
	$header = array($cookie);
	$content = $obj -> send(__URL, $header);
	if(empty($content)){
		return json_encode([
				'error' => 2,
				'message' => 'fail to get LuckyToken'
			]);
	}
	$pattern = '/\'luckyToken\', \'(\w+)\'/';
	preg_match_all($pattern, $content, $res);
	if(empty($res[1][0])){
		return json_encode([
				'error' => 2,
				'message' => 'fail to get LuckyToken'
			]);
	}
	$luckyToken = $res[1][0];
	return $luckyToken;
}

// 获取用户信息
function getUserInfo($bduss = ''){
	$obj = new myCurl();
	$cookie = 'Cookie:'.$bduss;
	$header = array($cookie);
	$content = $obj -> send(__URL, $header);
	if(empty($content)){
		return json_encode([
				'error' => 2,
				'message' => 'fail to get usernfo'
			]);
	}
	$pattern = '/user-name\">(.+?)</';
	preg_match_all($pattern, $content, $res);
	if(empty($res[1][0])){
		return json_encode([
				'error' => 3,
				'message' => 'fail to get userinfo'
			]);
	}
	$username = $res[1][0];
	$username = mb_convert_encoding($username, 'utf-8', 'gbk');
	return json_encode([
				'error' => 0,
				'username' => $username
			]);
}

?>