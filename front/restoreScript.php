<?php
define('TOKEN','token');
$db = new mysqli('localhost','root','','');
$params = [
  'client_id' => 7006794,
  'client_secret' => 'secret',
  'redirect_uri' => 'https://sharatest.ru/restoreMain/',
  'code' => $_GET['code']
];
$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?'.http_build_query($params)));
if($token->access_token != ''){
  $allowed = api('messages.isMessagesFromGroupAllowed',['group_id' => 182959723,'user_id' => $token->user_id])->response->is_allowed == 1;
  if($allowed){
    $q = $db->query("SELECT * FROM users WHERE vk=".$token->user_id);
    if($q->num_rows > 0){
      $r = $q->fetch_assoc();
      $pass = generate_password(rand(6,8));
      $text = 'Новый пароль от аккаунта '.$r['username'].' - '.$pass;
      $db->query("UPDATE users SET password='".password_hash($pass,PASSWORD_DEFAULT)."' WHERE vk=".$token->user_id);
      api('messages.send',['peer_id' => $token->user_id,'message' => $text,'random_id' => rand(0,99999)]);
      header('Location: /?msg=2');
    } else{
      echo 'Эта страница не привязана ни к одному аккаунту. <a href="/">На главную</a>';
    }
  } else{
    echo 'Вы запретили группе присылать вам сообщения. Чтобы разрешить снова, напишите любое сообщение в <a href="https://vk.me/sharatest">группу</a>, а затем попробуйте <a href="https://sharatest.ru/restore/">снова</a>';
  }
} else{
  echo 'auth error: '.$_GET['error'].'. description: '.$_GET['error_description'];
}

function api($method,$params){
  return json_decode(file_get_contents('https://api.vk.com/method/'.$method.'?'.http_build_query($params).'&access_token='.TOKEN.'&v=5.95'));
}

function generate_password($number)
{
  $arr = array('a','b','c','d','e','f',
               'g','h','i','j','k','l',
               'm','n','o','p','r','s',
               't','u','v','x','y','z',
               'A','B','C','D','E','F',
               'G','H','I','J','K','L',
               'M','N','O','P','R','S',
               'T','U','V','X','Y','Z',
               '1','2','3','4','5','6',
               '7','8','9','0');
  // Генерируем пароль
  $pass = "";
  for($i = 0; $i < $number; $i++)
  {
    // Вычисляем случайный индекс массива
    $index = rand(0, count($arr) - 1);
    $pass .= $arr[$index];
  }
  return $pass;
}
?>
