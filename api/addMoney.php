<?php
if($_SERVER['REMOTE_ADDR'] != '217.182.75.16'){
	echo 'forbidden';
	return;
}
$db = new mysqli('localhost','root','','');
$db->query("UPDATE users SET money=money+".$_POST['amount']." WHERE token='".$_POST['ticket']."'");
?>
