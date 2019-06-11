<?php
if($_SERVER['REMOTE_ADDR'] != '217.182.75.16'){
	echo 'forbidden';
	return;
}
$db = new mysqli('localhost','root','r4ewo1ss89','sharatest');
$db->query("UPDATE users SET gold=gold+".$_POST['amount']." WHERE token='".$_POST['ticket']."'");
?>