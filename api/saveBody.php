<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if($_SERVER['REMOTE_ADDR'] != '217.182.75.16'){
	echo 'forbidden';
	return;
}
$db = new mysqli('localhost','root','','');
$db->query("UPDATE users SET body_color=".$_POST['body_color'].",ears_color=".$_POST['ears_color'].",ears=".$_POST['ears'].",eyes=".$_POST['eyes'].",horns=".$_POST['horns'].",legs=".$_POST['legs'].",legs_color=".$_POST['legs_color'].",mouth=".$_POST['mouth'].",nose=".$_POST['nose'].",peak=".$_POST['peak']." WHERE token='".$_POST['token']."'");
?>
