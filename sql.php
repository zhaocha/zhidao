<?php
// require_once 'config.php';
date_default_timezone_set('PRC');
header('Content-Type:text/html; charset=utf-8');
class sql extends mysqli{
	private $host     = '';
	private $user     = '';
	private $password = '';
	private $dbName   = '';

	function __construct(){
		require_once 'config.php';
		$this->host     = $db['host'];
 		$this->user     = $db['user'];
 		$this->password = $db['password'];
 		$this->dbName   = $db['dbName'];
		parent::__construct($this->host,$this->user,$this->password,$this->dbName);
		$this->query("SET NAMES UTF8");
		/*if($this->connect_error){
			die('Connect error:'.$this->connect_error);
		}
		$this->query("SET NAMES $char");
		if(!$this->select_db($dbName)){
			die('Select datebase error:'.$this->error);
		}
		echo "ok";*/
	}

	public function selectUserInfo(){
		$sql = "SELECT `username`,`bduss` FROM `userinfo` ";
		//$sql = "select $values from $dbTable";
		//$link->query($sql);
		$res = $this->query($sql);	
		while($row = $res->fetch_assoc()){
			$r[] = $row;
		}
		return $r;
	}

	function checkUserExists($username){
		$sql = "SELECT `id` FROM `userinfo` WHERE `username`='{$username}' LIMIT 1";
		$res = $this->query($sql);	
		$row = $res->num_rows;
		if(empty($row)){
			return true;
		}else return false;
	}

	function addUserInfo($username = '', $bduss = ''){
		$sql = "INSERT INTO userinfo(`username`,`bduss`) VALUES('{$username}','{$bduss}')";
		$this -> query($sql);
	}
}
?>