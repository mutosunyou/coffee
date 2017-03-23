<?php
//初期==============================================
require_once('../master/prefix.php');

$to=mailFromUserID($_POST['userID']);

$subject = '【珈琲会員の皆様へ】';

$message.= '今月の支払状況が支払済から未払いに戻されました。'.PHP_EOL;
$message.= '意図した状態でなければ集金係の方にご確認ください。'.PHP_EOL;
$message.= 'http://192.168.100.209/coffee/index.php'.PHP_EOL.PHP_EOL;

$headers = 'remote_manager@sunyou.co.jp';

sendmail($to,'',str_replace('\'','’',$subject),str_replace('\'','’',$message),$headers);

echo $to;
