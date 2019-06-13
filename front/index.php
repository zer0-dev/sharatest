<?php
/*if($_SERVER['HTTP_HOST'] != '217.182.75.16' && $_SERVER['HTTP_HOST'] != 'localhost') header('Location: /soon.html');*/
?>
<html>
 <head>
  <title>SharaTest</title>
  <link rel="stylesheet" href="style.min.css?<?php echo filectime('style.min.css');?>">
  <script>
  if (window.location.protocol !== 'https:') {
    window.location = 'https://' + window.location.hostname + window.location.pathname + window.location.hash;
}
</script>
 </head>
 <body>
  <div id="starter">
   <img src="logo.jpg" id="logo">
   <button onclick="play()" id="playBtn">Играть</button>
 </div>
  <div id="container"></div>
  <div id="menu"><a href="https://vk.com/sharatest" target="_blank">Группа ВКонтакте</a> <a id="settings">Настройки</a> <a href="https://sharatest.ru/items/" target="_blank">Список вещей</a> <a href="https://sharatest.ru/cmds.html" target="_blank">Список команд</a> <a href="https://www.donationalerts.com/r/sharatest" target="_blank">Донат</a> <a href="https://github.com/zer0-dev/sharatest" target="_blank">GitHub</a> <a id="logout">Выйти</a></div>
  <div class="overlay">
   <div class="window">
   </div>
  </div>
  <?php
  $msgs = [
    'Страница ВКонтакте успешно привязана','Страница ВКонтакте уже привязана к одному из аккаунтов','Новый пароль выслан в сообщении ВКонтакте'
  ];
  if($_GET['msg'] != '') echo '<script>alert("'.$msgs[$_GET['msg']].'"); window.location = "https://sharatest.ru";</script>';
   ?>
  <script src="script.min.js?<?php echo filectime('script.min.js');?>"></script>
 </body>
</html>
