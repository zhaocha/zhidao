<?php
include 'spider.php';
require_once 'sql.php';

function freeLottery($message = ''){
	$obj = new sql();
	$userInfo = $obj -> selectUserInfo();
	$userNum = count($userInfo);
	for($i = 0; $i < $userNum; $i++){
		$url = getUrl($userInfo[$i]['bduss']);
		$res[] = lottery($url, $userInfo[$i]['bduss']);
		$res[$i]['message'] = $message;
	}
}
?>