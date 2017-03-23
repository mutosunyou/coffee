<?php
require_once('../master/prefix.php');

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
$sql = 'select userID from member where available=1';
$rst = selectData(DB_NAME,$sql);

$sql = 'update member set voted=1 where userID='.$rst[rand(0,(count($rst)-1))]['userID'];
deleteFrom(DB_NAME,$sql);

//今月飲む人に集計係にお金を渡すようにメールする。
$sql='select * from member where available=1';
$rst=selectData(DB_NAME,$sql);

$to='';
for($i=0;$i<count($rst);$i++){
  $to .= mailFromUserID($rst[$i]['userID']);
  if($i!=(count($rst)-1)){
    $to.=', ';
  }
}

$sql='select * from member where voted=1';
$rst_voted=selectData(DB_NAME,$sql);

$subject = '【珈琲会員の皆様へ】';

$message.= '今月珈琲サーバーを利用される方にメールを配信しています。'.PHP_EOL;
$message.= '今月の集金係は'.nameFromUserID($rst[0]['userID']).'です。集金係へなるべく早く支払をお願いします。'.PHP_EOL.PHP_EOL;
$message.= '集金係は集金したお金を伊藤さんに渡してください。';
$message.= 'また、お金を受け取ったら下記システムに支払済の方のチェックをお願いします。';
$message.= 'http://192.168.100.209/coffee/index.php'.PHP_EOL.PHP_EOL;

$headers = 'remote_manager@sunyou.co.jp';

sendmail($to,'',str_replace('\'','’',$subject),str_replace('\'','’',$message),$headers);

echo $to;
