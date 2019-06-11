<?php
session_start();
$db = new mysqli('localhost','root','','');
//server config
$servers = [
 ['33806','217.182.75.16','1935','main']
];

switch($_GET['method']){
	case 'ServerAction':
	 $user = $db->query("SELECT * FROM users WHERE token='".$_SESSION['token']."'")->fetch_assoc();
	 $serversList = '<servers>';
	 for($i=0;$i<count($servers);$i++){
	 	$ii = $i+1;
	 	$serversList .= '<item Id="'.$ii.'" TRId="'.$servers[$i][0].'" RId="5" RTMPUrl="rtmp://'.$servers[$i][1].':'.$servers[$i][2].'/'.$servers[$i][3].'" Load="0" QuestLocationLoad="0" FriendsCount="1" ClubsCount="5" Weight="5.1" />';
	 }
	 if($user['roleflags'] >= 393230) $serversList .= '<item Id="99" TRId="9999" RId="5" RTMPUrl="rtmp://217.182.75.16/dev" Load="0" QuestLocationLoad="0" FriendsCount="1" ClubsCount="5" Weight="5.1" />';
	 $serversList .= '</servers>';
	 $ban = "";
	 if($user['banned'] == 1) $ban = 'BanDateExpired="31-02-2020 07:08:14" BanTextResourceID="162"';
	 $userData = '<user UserId="'.$user['id'].'" hwId="'.$user['token'].'" ticketId="'.$user['token'].'" RoleFlags="'.$user['roleflags'].'" '.$ban.' />';
	 $config = '<config><item Id="1" Parameter="AccessRoleFlags" Value="0" Type="number" /><item Id="3" Parameter="IsPreloaderFast" Value="0" Type="bool" /><item Id="4" Parameter="InitialVolumeValue" Value="'.$user['volume'].'" Type="number" /><item Id="6" Parameter="IsPreloaderEnabled" Value="1" Type="bool" /><item Id="7" Parameter="IsStartupHomeLocation" Value="0" Type="bool" /><item Id="8" Parameter="SwfVersion" Value="" Type="string" /><item Id="9" Parameter="SynchronizeAvatarRotation" Value="1" Type="bool" /><item Id="10" Parameter="StatisticsSendInterval" Value="0" Type="number" /><item Id="12" Parameter="LanguageId" Value="1" Type="number" /><item Id="13" Parameter="SnId" Value="1" Type="number" /><item Id="14" Parameter="IsInternational" Value="0" Type="bool" /><item Id="15" Parameter="AutoServerSelectionAllowed" Value="1" Type="bool" /><item Id="16" Parameter="DaysToFullSoil" Value="28" Type="number" /><item Id="17" Parameter="DaysToHalfSoil" Value="14" Type="number" /><item Id="18" Parameter="CurrentQuest" Value="421" Type="number" /><item Id="20" Parameter="TypeWeapon" Value="'.$user['weapon'].'" Type="number" /><item Id="21" Parameter="SkipTutorial" Value="1" Type="bool" /><item Id="23" Parameter="CurrentQuestGroup" Value="6161" Type="string" /><item Id="24" Parameter="IsNewRegistration" Value="1" Type="bool" /><item Id="25" Parameter="IsMotivatingAdsOn" Value="0" Type="bool" /></config>';
	 $system = '<system ServerDate="'.date('Y-m-d H:i:s').'" RPath="fs/3p897j5lf4e0j!12349.swf" RVersion="56" />';
	 echo '<?xml version="1.0" encoding="utf-8"?> <response> <promotion> <i MRId="20106" State="1" /> <i MRId="30896" State="7" /> </promotion> <promotion_banner> <i MRId="30896" /> </promotion_banner> <promotion_whats_new> <i Id="386" TypeId="1" MRId="20143" /> <i Id="611" TypeId="2" MRId="27179" /> <i Id="784" TypeId="2" MRId="30841" /> <i Id="785" TypeId="2" MRId="30895" /> <i Id="786" TypeId="2" MRId="30897" /> </promotion_whats_new> <preloader> <i MRId="30894" ShowTime="20;00" /> </preloader> <sn_status IsBinded="0" /> <phone> <messages/> </phone> <user_name Value="test" /> <postcard> <messages/> </postcard> <licence_promotion> <item Id="1" GroupId="0" OrderId="0" MRId="14763" /> <item Id="2" GroupId="0" OrderId="1" MRId="14764" /> <item Id="3" GroupId="0" OrderId="2" MRId="14765" /> <item Id="4" GroupId="1" OrderId="0" MRId="14766" /> <item Id="5" GroupId="1" OrderId="1" MRId="14767" /> <item Id="6" GroupId="1" OrderId="2" MRId="14768" /> <item Id="7" GroupId="2" OrderId="0" MRId="20597" /> <item Id="8" GroupId="2" OrderId="1" MRId="20598" /> <item Id="9" GroupId="2" OrderId="2" MRId="20599" /> </licence_promotion> <flags EntranceCount="2600" /> <tutorial> <item Id="-1" State="1" /> <item Id="1" State="1" /> <item Id="2" State="1" /> <item Id="3" State="1" /> <item Id="4" State="1" /> <item Id="5" State="1" /> </tutorial> <miniquest> <i Id="148515433" MiniquestId="90004" IsPostponed="0" StartDate="2018-06-06T18:58:28.113"> <i Id="298265808" TaskId="900041" IsFinished="0" Counter="3" /> <i Id="298265809" TaskId="900042" IsFinished="0" Counter="0" /> <i Id="298265810" TaskId="900043" IsFinished="1" Counter="0" /> </i> </miniquest> <grants ReceivingCount="0" /> <requests ReceivingCount="0" /> <cdata value="'. encrypt($config) .'" /> <cdata value="'. encrypt($system) .'" /> <cdata value="'. encrypt($userData) .'" /> <cdata value="'. encrypt($serversList) .'" /> </response>';
	 break;
	case 'Ping':
	 echo '<response isPong="true" />';
	 break;
	default:
	 echo 'osujdaushe smtoru 29.05.2019 16:37';
	 break;
}

function encrypt($str){
	return bin2hex(rc4('_level0',$str));
}

function rc4($key, $str) {

	$s = array();

	for ($i = 0; $i < 256; $i++) {

		$s[$i] = $i;

	}

	$j = 0;

	for ($i = 0; $i < 256; $i++) {

		$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;

		$x = $s[$i];

		$s[$i] = $s[$j];

		$s[$j] = $x;

	}

	$i = 0;

	$j = 0;

	$res = '';

	for ($y = 0; $y < strlen($str); $y++) {

		$i = ($i + 1) % 256;

		$j = ($j + $s[$i]) % 256;

		$x = $s[$i];

		$s[$i] = $s[$j];

		$s[$j] = $x;

		$res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);

	}

	return $res;

}
?>
