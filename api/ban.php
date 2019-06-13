<?php
if($_SERVER['REMOTE_ADDR'] != '217.182.75.16'){
  header('HTTP/1.0 403 Forbidden');
  echo 'Forbidden';
  return;
}

$db = new mysqli('localhost', 'root', '', '');
$_POST['ticket'] = str_replace("'",'',$_POST['ticket']);


if (isset($_POST["ticket"])) {
	$user = $db->query("SELECT * FROM users WHERE token = '" . $_POST["ticket"] . "';");

	if ($user->num_rows <= 0) {
		exit;
	}

	$a = $user->fetch_assoc();
	if ($a['roleflags'] >= "131086") {
		$q = $db->query("UPDATE users SET banned = 1,moder_ban='".$a['username']."' WHERE id = " . $_POST["id"] . ";");
	}
}
?>
