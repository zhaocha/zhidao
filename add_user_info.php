<?php
include 'sql.php';

$bduss = htmlspecialchars($_POST['bduss']);
if(!empty($bduss)){
	include 'spider.php';
	$res = json_decode(getUserInfo($bduss), true);
	if($res['error'] === 0){
		$username = htmlspecialchars($res['username']);
		$obj = new sql();
		$res = $obj->checkUserExists($username);
		if($res === false){
			die('the user is already exists');
		}else {
			$obj->addUserInfo($username, $bduss);
			die('Successful operation');
		}
	}else die($res['message']);
}else die('invaild bduss');

?>