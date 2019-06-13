<?php
session_start();
if($_SERVER['HTTP_REFERER'] != 'https://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'https://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'https://localhost/' && $_SERVER['HTTP_REFERER'] != 'http://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'http://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'http://localhost/'){
	echo 'forbidden';
	return;
}
$db = new mysqli('localhost','root','','');
$user = $db->query("SELECT * FROM users WHERE token='".$_SESSION['token']."'")->fetch_assoc();
if($user['vk'] == 0){
	$vk = 'Страница ВКонтакте ещё не привязана к аккаунту. <a href="th.vk.com/authorize?client_id=7006794&redirect_uri=https://sharatest.ru/vk/&display=page&scope=offline&response_type=code&revoke=1&v=5.95">Привязать</a><br>';
} else{
	$vuser = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='.$user['vk'].'&fields=photo_50&lang=ru&access_token=token&v=5.95'))->response[0];
	$vk = '<div><img src="'.$vuser->photo_50.'" style="border-radius:999px;vertical-align:middle;"> <a href="https://vk.com/id'.$vuser->id.'" target="_blank">'.$vuser->first_name.' '.$vuser->last_name.'</a></div> <a onclick="removeVk()">Отвязать</a>';
}
echo '<span id="head">Настройки: '.$user['username'].'</span><p>Уровень: <input type="text" id="level" value="'.$user['level'].'"></p><p>Громкость по-умолчанию: <input type="text" id="volume" value="'.$user['volume'].'"></p><p>Снаряд: <input type="text" id="weapon" value="'.$user['weapon'].'"></p><p>Уровень магии: <input type="text" id="magic" value="'.$user['magic'].'"></p><p>Аватар: <select id="avatar"><option value="0">Нет</option><option value="1">Винни-Пух</option><option value="2">Крош</option><option value="3">Пин</option><option value="4">Нюша</option><option value="5">Карыч</option></select></p>ВКонтакте: '.$vk.'<br style="clear:left;"><button id="closeWin">Закрыть</button> <button id="saveSettings">Сохранить</button>';
?>
