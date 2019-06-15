<?php
session_start();
if($_SERVER['HTTP_REFERER'] != 'https://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'https://localhost/' && $_SERVER['HTTP_REFERER'] != 'https://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'http://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'http://localhost/' && $_SERVER['HTTP_REFERER'] != 'http://217.182.75.16/'){
	echo 'forbidden';
	return;
}
header('Content-Type: text/json');
define('SALT','SALT');
$db = new mysqli('localhost','root','','');
$res = ['response' => '','error' => []];
if($_GET['mode'] == 'true'){
	//register
	$username = trim($_GET['login']);
	$password = password_hash($_GET['password'],PASSWORD_DEFAULT);
	$token = 'token';
	$ip = $_SERVER['REMOTE_ADDR'];
	$inv = '';
	$regdate = date('Y-m-d').'T'.date('H-m-s').'.0';
	if (preg_match("/[^a-z,A-Z,0-9,а-я,А-Я,\-,\_]/u", $username)) {
	$res['error'][] = "Имя смешарика содержит недопустимые символы";
	}
	if(strlen($username) < 4 || strlen($username) > 20){
		$res['error'][] = 'Имя смешарика должно быть не короче 4 и не длиннее 20 символов';
	}
	if($db->query("SELECT * FROM users WHERE username='".$username."'")->num_rows > 0){
		$res['error'][] = 'Имя смешарика уже занято';
	}
	if(strlen($_GET['password']) < 6 || strlen($_GET['password']) > 14){
		$res['error'][] = 'Пароль должен быть не короче 6 и не длиннее 14 символов';
	}
	if(empty($res['error'])){
	if($db->query("INSERT INTO users (username,password,token,regdate,inv,house_str,house_inv) VALUES ('".$username."','".$password."','".$token."','".$regdate."','.$inv.','','ID>3676|AObjectTypeId>1|AObjectId>3676|AObjectRefTypeId>20|MediaResourceID>10223|TextResourceID>10641|IsActive>0')")){
		$res['response'] = 'ok';
	} else{
		$res['error'][] = $db->error;
	}
	}
} else{
	//login
	$username = (htmlspecialchars($_GET['login']) == '&quot; client &quot;') ? '&quot; client &quot;' : trim($_GET['login']);
	$password = htmlspecialchars($_GET['password']);
	$q1 = $db->query("SELECT * FROM users WHERE username='".$username."'");
	/*if (preg_match("/[^a-z,A-Z,0-9,а-я,А-Я,\-,\_]/u", $username)) {
	$res['error'][] = "Имя смешарика содержит недопустимые символы";
	}*/
	if($q1->num_rows == 0){
		$res['error'][] = 'Смешарик не найден';
	}
	$u = $q1->fetch_assoc();
	if(!password_verify($password,$u['password'])){
		$res['error'][] = 'Неправильный пароль';
	}
	if(empty($res['error'])){
		$token = 'token';
		$db->query("UPDATE users SET token='".$token."' WHERE id=".$u['id']);
		$_SESSION['token'] = $token;
		$_SESSION['uid'] = $u['id'];
		$res['response'] = 'ok';
	}
}
$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
	'secret' => 'secret',
	'response' => $_GET['token']
]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$cap = json_decode(curl_exec($ch));
if($cap->score == 0){
	$res['error'][] = 'bot detected';
	unset($_SESSION['token']);
}
echo json_encode($res);
?>
