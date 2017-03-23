<?php
//初期==============================================
require_once('../master/prefix.php');

$sql='select * from member';
$rst=selectData(DB_NAME,$sql);

$to='';
for($i=0;$i<count($rst);$i++){
  $to .= mailFromUserID($rst[$i]['userID']);
  if($i!=(count($rst)-1)){
    $to.=', ';
  }
}

$subject = '【珈琲会員の皆様へ】';

$message = 'コーヒー会員の方に連絡しています。'.PHP_EOL.PHP_EOL;
$message.= '来月コーヒーサーバーを利用したい方は、今月中に会員ページの表示を「来月利用する」にしてください。'.PHP_EOL;
$message.= 'http://192.168.100.209/coffee/index.php'.PHP_EOL.PHP_EOL;
$message.= '来月1日９時の時点で利用者を決定します。'.PHP_EOL.PHP_EOL;

$headers = 'remote_manager@sunyou.co.jp';

sendmail($to,'',str_replace('\'','’',$subject),str_replace('\'','’',$message),$headers);

echo $to;
