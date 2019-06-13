<?php
session_start();
if($_GET['error'] != '') header('Location: /');
if(strlen($_SESSION['token']) == 0){
   header('Location: /');
   return;
}
$db = new mysqli('localhost','root','','');
$params = [
  'client_id' => 7006794,
  'client_secret' => 'secret',
  'redirect_uri' => 'https://sharatest.ru/vk/',
  'code' => $_GET['code']
];
$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?'.http_build_query($params)));
if($token->access_token != ''){
  if($db->query("SELECT * FROM users WHERE vk=".$token->user_id)->num_rows == 0){
    if($db->query("UPDATE users SET vk=".$token->user_id." WHERE token='".$_SESSION['token']."'")){
      header('Location: /?msg=0');
    } else{
      echo $db->error;
    }
  } else{
    header('Location: /?msg=1');
  }
} else{
  echo 'auth error: '.$token->error.'. description: '.$token->error_description;
}
?>
