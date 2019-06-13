<?php
session_start();
/*if($_SERVER['HTTP_REFERER'] != 'https://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'https://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'https://localhost/' && $_SERVER['HTTP_REFERER'] != 'http://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'http://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'http://localhost/'){
	echo 'forbidden';
	return;
}*/
if(!isset($_SESSION['token'])){
	if($_GET['err'] == 1) echo 'Произошла ошибка<br>';
?>
<span id="head">Играть</span>
<br>Логин: <input type="text" id="login">
<br>Пароль: <input type="password" id="password">
<br><br><center><button id="mainBtn">Войти</button>
<br><br><a id="secondBtn" style="font-size:12px;">Регистрация</a>
<br><br><a href="https://sharatest.ru/restore/" target="_blank" style="font-size:12px;">Восстановить пароль</a>
<center>
<?php
} else{
	$db = new mysqli('localhost','root','','');
	if($db->query("SELECT * FROM users WHERE token='".$_SESSION['token']."'")->num_rows == 0){
		unset($_SESSION['token']);
		header('Location:/frame.php?err=1');
	}
	$db->query("UPDATE users SET ip='".$_SERVER['REMOTE_ADDR']."' WHERE token='".$_SESSION['token']."'");
?>
<div id="hidden"></div>
<div id="infobox">Чтобы добавить одежду: /add id (если предмет - фон, то он будет установлен)
<br>
По всем вопросам можно обратиться в группу ВК или на почту: support@sharatest.ru
<br>
<div style="color:red;">Вы можете поддержать проект материально <a href="https://www.donationalerts.com/r/sharatest" style="text-decoration:underline;color:red;" target="_blank">здесь</a></div></div>
<br>
<?php if($_SESSION['uid'] == 0 || $_SESSION['uid'] == -1){
	echo '<embed type="application/x-shockwave-flash" src="base2.swf?v=3" style="width: 100%;height:100%;" flashvars="game_server=https%3A%2F%2Fsharatest.ru%2F&url_path_server=https%3A%2F%2Fsharatest.ru%2F&portal_url=https%3A%2F%2Fsharatest.ru%2F&manual_server_selection=1&start_step=0&useHashInName=">';
} else{
	echo '<embed type="application/x-shockwave-flash" src="base.swf?v=3" style="width: 100%;height:100%;" flashvars="game_server=https%3A%2F%2Fsharatest.ru%2F&url_path_server=https%3A%2F%2Fsharatest.ru%2F&portal_url=https%3A%2F%2Fsharatest.ru%2F&manual_server_selection=1&start_step=0&useHashInName=">';
} ?>
<center><p id="sub">Создано на основе открытого исходного кода <a href="https://github.com/da15y/daisydale" target="_blank">DaisyDale</a>. Все права на ресурсы принадлежат <a href="http://www.nw-media.ru/" target="_blank">ООО «Новые Медиа»</a></p></center>
<?php
}
?>
