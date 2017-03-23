<?php
//初期==============================================
session_start();
require_once('master/prefix.php');

//localのみ============================
$_SESSION['loginid']=10042;
$_SESSION['login_name']="武藤　一徳";
//=======================================

//ログイン処理======================================
$sql = "SELECT * FROM employee";
$rst = selectData('master',$sql);
if (isset($_SESSION["login_name"])){
  $sessionCounter = 0;
  for($i = 0; $i < count($rst); $i++) {
    if ($_SESSION["login_name"] == $rst[$i]["person_name"]){
      $sessionCounter = $sessionCounter + 1;
    }
  }
  if ($sessionCounter == 0){
    header("Location: index.php");
    exit;
  }
  $_SESSION['loginid']=userIDFromName($_SESSION["login_name"]);
}else{
  header("Location: ../portal/index.php");
  exit;
}
$_SESSION['expires'] = time();
if ($_SESSION['expires'] < time() - 7) {
  session_regenerate_id(true);//sessionIDを生成しなおす
  $_SESSION['expires'] = time();
}

//ナビバー=========================================
$body='<nav class="navbar navbar-default navbar-fixed-top" role="navigation">';
$body.='<div class="container-fluid">';
$body.='<div class="navbar-header">';
$body.='<!-- 
  メニューボタン 
  data-toggle : ボタンを押したときにNavbarを開かせるために必要
  data-target : 複数navbarを作成する場合、ボタンとナビを紐づけるために必要
  -->
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-menu-1">
  <span class="sr-only">Toggle navigation</span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>';
$body.='<a class="navbar-brand" href="/php/menu" tabindex="-1"><img alt="Brand" src="./master/favicon.ico"></a>'; 
$body.='</div>';
$body.='<div class="collapse navbar-collapse" id="nav-menu-1">';

//左側
$body.='<ul class="nav navbar-nav">';
$body.='<li id="listrun" class="bankmenu"><a tabindex="-1">コーヒー</a></li>';
$body.='<li id="list" class="applymenu"><a href="index.php" tabindex="-1">履歴</a></li>';
$body.='<li id="list" class="active applymenu"><a href="#" tabindex="-1">入会・退会</a></li>';
$body.='</ul>';

//右側
$body.='<ul class="nav navbar-nav pull-right">';
$body.='<li><a href="./master/logout.php">ログアウト</a></li>';
$body.='<li><a tabindex="-1">'.$_SESSION['login_name'].'</a></li>';
$body.='</ul>';

$body.='</div>';
$body.='</div>';
$body.='</nav>';

//隙間調整=========================================
$body.='<div id="topspace" style="height:70px;"></div>';

//クラスと変数=====================================
$body.='<input id="userID" class="hidden" value="'.$_SESSION['loginid'].'">';
$sql='select * from author where userId='.$_SESSION['loginid'];
$rst=selectData(DB_NAME,$sql);

if(count($rst)>0){
  $author=1;
}else{
  $author=0;
}

//本文/////////////////////////////////////////////
//タイトル=========================================
$body.='<div class="container-fluid">';
$body.='<div class="container">';
$body.='<h2 class="toptitle">';
$body.='入会、退会';
$body.='</h2>';

$sql='select userID from member';
$rst_now=selectData(DB_NAME,$sql);
$sql='select id from employee where id not in (';
for($i=0;$i<count($rst_now);$i++){
  $sql.=$rst_now[$i]['userID'];
  if($i!=(count($rst_now)-1)){
    $sql.=',';
  }
}
$sql.=') and kairan=1';
$rst=selectData('master',$sql);

$body.='<p>　　入会、退会を希望される方は<a href="mailto:muto@sunyou.co.jp">企画室</a>までご連絡ください。</p><hr>';

if($author==1){
  $body.='<div class="clearfix"></div>';
  //入会/////////////////////////////////////////////
  $body.='<span style="float:left;margin-top:5px;">入会希望者：</span>';
  $body.='<select id="inner" class="form-control" style="width:200px;float:left;">';
  for($i=0;$i<count($rst);$i++){
    $body.='<option>'.nameFromUserID($rst[$i]['id']).'</option>';
  }
  $body.='</select>';
  $body.='<button  id="admission" class="btn btn-primary btn-sm" style="margin:0 0 0 20px;">入会</button>';
  $body.='<hr>';
  //入会おわり

  //退会/////////////////////////////////////////////
  $body.='<span style="float:left;margin-top:5px;">退会希望者：</span>';
  $body.='<select id="outer" class="form-control" style="width:200px;float:left;">';
  for($i=0;$i<count($rst_now);$i++){
    $body.='<option>'.nameFromUserID($rst_now[$i]['userID']).'</option>';
  }
  $body.='</select>';
  $body.='<button id="withdrawal" class="btn btn-danger btn-sm" style="margin:0 0 0 20px;">退会</button>';
  //退会終わり
}
$body.='</div>';//container
$body.='</div>';//

//ヘッダー===========================================
$header ='<script type="text/javascript" src="index.js"></script>';
$header.='<style type="text/css">';
$header.='<!--
  .input-group{
  margin:5px 10px 5px 0;
  }
  -->';
$header.='</style>';

//HTML作成===========================================
echo html('コーヒー会員入会・退会',$header, $body);
