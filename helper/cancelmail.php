<?php
//初期==============================================
require_once('../master/prefix.php');

$to=mailFromUserID($_POST['userID']);

$subject = '【珈琲会員の皆様へ】';

$message = 'コーヒー会員の方に連絡しています。'.PHP_EOL.PHP_EOL;
$message.= '今月の'.PHP_EOL;
$message.= 'http://192.168.100.209/coffee/index.php'.PHP_EOL.PHP_EOL;

$headers = 'remote_manager@sunyou.co.jp';

sendmail($to,'',str_replace('\'','’',$subject),str_replace('\'','’',$message),$headers);

echo $to;
