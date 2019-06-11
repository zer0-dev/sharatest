<?php
session_start();
if($_SERVER['HTTP_REFERER'] != 'https://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'https://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'https://localhost/' && $_SERVER['HTTP_REFERER'] != 'http://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'http://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'http://localhost/'){
	echo 'forbidden';
	return;
}
$db = new mysqli('localhost','root','','');
$user = $db->query("SELECT * FROM users WHERE token='".$_SESSION['token']."'")->fetch_assoc();
echo '<span id="head">Настройки: '.$user['username'].'</span><p>Уровень: <input type="text" id="level" value="'.$user['level'].'"></p><p>Громкость по-умолчанию: <input type="text" id="volume" value="'.$user['volume'].'"></p><p>Снаряд: <input type="text" id="weapon" value="'.$user['weapon'].'"></p><p>Уровень магии: <input type="text" id="magic" value="'.$user['magic'].'"></p><p>Аватар: <select id="avatar"><option value="0">Нет</option><option value="1">Винни-Пух</option><option value="2">Крош</option><option value="3">Пин</option><option value="4">Нюша</option><option value="5">Карыч</option></select></p><br><button id="closeWin">Закрыть</button> <button id="saveSettings">Сохранить</button>';
?>
