<?php
require_once('../master/prefix.php');
//先月集金した人
$sql='select userID from member where voted=1';
$rst_jogai = selectData(DB_NAME,$sql);

//available初期化
$sql = 'update member set available=0';
deleteFrom(DB_NAME,$sql);

//来月も飲むと宣言した人をavailableに
$sql='update member set available=1 where next=1';
deleteFrom(DB_NAME,$sql);

//集計係を初期化
$sql = 'update member set voted=0';
deleteFrom(DB_NAME,$sql);

//availableの中から集計係を選ぶ
$sql = 'select userID from member where userID not in ('.$rst_jogai[0]['userID'].',1,11,40,10001) and available=1';
$rst = selectData(DB_NAME,$sql);

$sql = 'update member set voted=1 where userID='.$rst[rand(0,(count($rst)-1))]['userID'];
deleteFrom(DB_NAME,$sql);

//メール配信
//宛先
$sql_next = 'select userID from member where next=1 or userID=10042';
$rst_next = selectData(DB_NAME,$sql_next);
$to='';
for($i=0;$i<count($rst_next);$i++){
  $to .= mailFromUserID($rst_next[$i]['userID']);
  if($i!=(count($rst)-1)){
    $to.=', ';
  }
}

$sql_voted='select * from member where voted=1';
$rst_voted=selectData(DB_NAME,$sql_voted);

//メール文面
$subject = '【珈琲会員の皆様へ】'.PHP_EOL.PHP_EOL;

$message.= '今月珈琲サーバーを利用される方にメールを配信しています。'.PHP_EOL;
$message.= '今月の集金係は'.nameFromUserID($rst_voted[0]['userID']).'です。集金係へ早めの支払をお願いします。'.PHP_EOL.PHP_EOL;

$message.= 'また、集金係はお金を受け取ったら下記システムに支払済の方のチェックをお願いします。'.PHP_EOL;
$message.= 'http://192.168.100.209/coffee/index.php'.PHP_EOL.PHP_EOL;

$headers = 'remote_manager@sunyou.co.jp';

sendmail($to,'',str_replace('\'','’',$subject),str_replace('\'','’',$message),$headers);

echo $to;
