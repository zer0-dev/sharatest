<?php
if($_SERVER['REMOTE_ADDR'] != '217.182.75.16'){
	echo 'forbidden';
	return;
}
header('Content-Type: text/plain; charset=utf-8');
$db = new mysqli('localhost','root','','');
$_GET['token'] = str_replace('?','',$_GET['token']);
$user = $db->query("SELECT * FROM users WHERE token='".$_GET['token']."'")->fetch_assoc();
//echo $_GET['token'];
echo 'id='.$user['id'].'&username='.$user['username'].'&level='.$user['level'].'&regdate='.$user['regdate'].'&avatar='.$user['avatar'].'&bg='.$user['bg'].'&inventory='.$user['inv'].'&roleflags='.$user['roleflags'].'&money='.$user['money'].'&gold='.$user['gold'].'&magic='.$user['magic'].'&banned='.$user['banned'].'&friends='.$user['friends'].'&reqs='.$user['reqs'].'&body_color='.$user['body_color'].'&legs='.$user['legs'].'&legs_color='.$user['legs_color'].'&ears='.$user['ears'].'&ears_color='.$user['ears_color'],'&eyes='.$user['eyes'].'&nose='.$user['nose'].'&mouth='.$user['mouth'].'&peak='.$user['peak'].'&horns='.$user['horns'].'&house_id='.$user['house_id'].'&house_str='.$user['house_str'];
?>
