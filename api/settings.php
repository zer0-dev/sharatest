<?php
session_start();
if($_SERVER['HTTP_REFERER'] != 'https://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'https://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'https://localhost/' && $_SERVER['HTTP_REFERER'] != 'http://sharatest.ru/' && $_SERVER['HTTP_REFERER'] != 'http://217.182.75.16/' && $_SERVER['HTTP_REFERER'] != 'http://localhost/'){
	echo 'forbidden';
	return;
}
header('Content-Type: text/json');
$db = new mysqli('localhost','root','','');
$res = ['response' => '','error' => []];
$user = $db->query("SELECT * FROM users WHERE token='".$_SESSION['token']."'");
$exists = $user->num_rows > 0;
if($exists){
	$avas = ['avatar',"'IsBodyPart>true|BodyPartTypeId>5|MediaResourceID>0|LayerID>25|BodyPartId>30|Id>30|Color>NaN;IsBodyPart>true|BodyPartTypeId>6|MediaResourceID>0|LayerID>39|BodyPartId>31|Id>31|Color>16762375;IsBodyPart>true|BodyPartTypeId>7|MediaResourceID>0|LayerID>29|BodyPartId>40|Id>40|Color>NaN;IsBodyPart>true|BodyPartTypeId>2|MediaResourceID>0|LayerID>9|BodyPartId>1|Id>1|Color>NaN;IsBodyPart>true|BodyPartTypeId>3|MediaResourceID>0|LayerID>19|BodyPartId>2|Id>2|Color>16762375;IsBodyPart>false|GoodID>23|MediaResourceID>51|GoodTypeID>40|LayerID>27|Id>23'","'IsBodyPart>true|BodyPartTypeId>5|MediaResourceID>0|LayerID>25|BodyPartId>30|Id>30|Color>NaN;IsBodyPart>true|BodyPartTypeId>6|MediaResourceID>0|LayerID>39|BodyPartId>31|Id>31|Color>16762375;IsBodyPart>true|BodyPartTypeId>7|MediaResourceID>0|LayerID>29|BodyPartId>40|Id>40|Color>NaN;IsBodyPart>true|BodyPartTypeId>2|MediaResourceID>0|LayerID>9|BodyPartId>1|Id>1|Color>NaN;IsBodyPart>true|BodyPartTypeId>3|MediaResourceID>0|LayerID>19|BodyPartId>2|Id>2|Color>16762375;IsBodyPart>false|GoodID>588|MediaResourceID>1260|GoodTypeID>40|LayerID>27|Id>588'","'IsBodyPart>true|BodyPartTypeId>5|MediaResourceID>0|LayerID>25|BodyPartId>30|Id>30|Color>NaN;IsBodyPart>true|BodyPartTypeId>6|MediaResourceID>0|LayerID>39|BodyPartId>31|Id>31|Color>16762375;IsBodyPart>true|BodyPartTypeId>7|MediaResourceID>0|LayerID>29|BodyPartId>40|Id>40|Color>NaN;IsBodyPart>true|BodyPartTypeId>2|MediaResourceID>0|LayerID>9|BodyPartId>1|Id>1|Color>NaN;IsBodyPart>true|BodyPartTypeId>3|MediaResourceID>0|LayerID>19|BodyPartId>2|Id>2|Color>16762375;IsBodyPart>false|GoodID>586|MediaResourceID>1258|GoodTypeID>40|LayerID>27|Id>586'","'IsBodyPart>true|BodyPartTypeId>5|MediaResourceID>0|LayerID>25|BodyPartId>30|Id>30|Color>NaN;IsBodyPart>true|BodyPartTypeId>6|MediaResourceID>0|LayerID>39|BodyPartId>31|Id>31|Color>16762375;IsBodyPart>true|BodyPartTypeId>7|MediaResourceID>0|LayerID>29|BodyPartId>40|Id>40|Color>NaN;IsBodyPart>true|BodyPartTypeId>2|MediaResourceID>0|LayerID>9|BodyPartId>1|Id>1|Color>NaN;IsBodyPart>true|BodyPartTypeId>3|MediaResourceID>0|LayerID>19|BodyPartId>2|Id>2|Color>16762375;IsBodyPart>false|GoodID>592|MediaResourceID>1264|GoodTypeID>40|LayerID>27|Id>592'","'IsBodyPart>true|BodyPartTypeId>5|MediaResourceID>0|LayerID>25|BodyPartId>30|Id>30|Color>NaN;IsBodyPart>true|BodyPartTypeId>6|MediaResourceID>0|LayerID>39|BodyPartId>31|Id>31|Color>16762375;IsBodyPart>true|BodyPartTypeId>7|MediaResourceID>0|LayerID>29|BodyPartId>40|Id>40|Color>NaN;IsBodyPart>true|BodyPartTypeId>2|MediaResourceID>0|LayerID>9|BodyPartId>1|Id>1|Color>NaN;IsBodyPart>true|BodyPartTypeId>3|MediaResourceID>0|LayerID>19|BodyPartId>2|Id>2|Color>16762375;IsBodyPart>false|GoodID>659|MediaResourceID>1396|GoodTypeID>40|LayerID>27|Id>659'"]; //0 - default, 1 - vinni puh, 2 - krosh, 3 - pin, 4 - nusha, 5 - karich
	$level = $_GET['level'];
	$volume = $_GET['volume'];
	$weapon = $_GET['weapon'];
	$magic = $_GET['magic'];
	$avatar = $avas[$_GET['avatar']];
	if (preg_match("/[^a-z,A-Z,0-9,а-я,А-Я,\-,\_]/u", $level)) {
	$res['error'][] = "Уровень содержит недопустимые символы";
	}
	if (!is_numeric($volume)) {
	$res['error'][] = "Громкость содержит недопустимые символы";
	}
	if (!is_numeric($weapon)) {
	$res['error'][] = "Снаряд содержит недопустимые символы";
	}
	if (!is_numeric($magic)) {
	$res['error'][] = "Уровень магии содержит недопустимые символы";
	}
	if(!is_numeric($_GET['avatar'])){
		$res['error'][] = "Аватар содержит недопустимые символы";
	}
	if(strlen($level) > 5 || strlen($level) == 0) $res['error'][] = 'Уровень не может быть пустым или больше 5 символов';
	if($volume < 0 || $volume > 100) $res['error'][] = 'Громкость должна быть в пределах от 0 до 100';
	if($weapon < 0 || $weapon > 3) $res['error'][] = 'Снаряд должен быть в пределах от 0 до 3';
	if($magic < 0 || $magic > 10) $res['error'][] = 'Уровень магии должен быть в пределах от 0 до 10';
	if(empty($res['error'])){
		if($db->query("UPDATE users SET level='".$level."',volume=".$volume.",weapon=".$weapon.",magic=".$magic.",avatar=".$avatar." WHERE token='".$_SESSION['token']."'")){
			$res['response'] = 'ok';
		} else{
			$res['error'][] = $db->error;
		}
	}
} else{
	$res['error'][] = 'user doesnt exist '.$user->num_rows;
}
echo json_encode($res);
?>
