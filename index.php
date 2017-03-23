<?php
//初期==============================================
session_start();
require_once('master/prefix.php');

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
$body.='<li id="list" class="active applymenu"><a href="#" tabindex="-1">履歴</a></li>';
$body.='<li id="list" class="applymenu"><a href="inout.php" tabindex="-1">入会・退会</a></li>';
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

//自分がメンバーかどうか、利用するかどうか確認→next
$sql='select * from member where userID='.$_SESSION['loginid'];
$rst=selectData(DB_NAME,$sql);
if($rst[0]['next']==1){
  $next=true;
}else{
  $next=false;
}

$sql='select * from member where voted=1';
$rst_vote=selectData(DB_NAME,$sql);

//クラスと変数=====================================
$body.='<input id="userID" class="hidden" value="'.$_SESSION['loginid'].'">';
$body.='<input id="ava" class="hidden" value='.$next.'>';

//本文/////////////////////////////////////////////
//タイトル=========================================
$body.='<div class="container-fluid">';
$body.='<div class="container">';
$body.='<h2 class="toptitle">';
$body.='コーヒー会員';
$body.='</h2>';
//トグル
$body.='<div class="well" style="height:200px;width:750px;">';
if(isset($rst[0]['next'])!=0){
  $body.='<div id="exp" style="float:left;display:inline-block;margin:0 0 0 10px;"></div>';

  $body.='<div id="toggle" class="toggle-iphone" style="float:left;">';
  $body.='<div class="toggle toggle-select" data-type="select" data-toggle-on=';
  if($next=="true"){
    $body.='"true"';
  }else{
    $body.='"false"';
  }
  $body.='style="width:100px;display:inline-block;"></div>';
  $body.='</div>';
}
$body.='<ul class="list-group" style="float:left;margin:0 0 0 30px;">';
$body.='<li class="list-group-item">コーヒーサーバー利用料：１０００円／月</li>';
$body.='<li class="list-group-item">利用の有無は前月中に選択。1日の9時に決定。</li>';
$body.='<li class="list-group-item">集金係は1日に抽選で選ぶ<今月は<font color="blue">'.nameFromUserID($rst_vote[0]['userID']).'</font>さんです></li>';
$body.='</ul>';

$body.='</div>';

$body.='<div class="clearfix"></div>'; 
$body.='<div style="height:20px;"></div>';

//リスト
$body.='<div id="lister"></div>';

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
echo html('コーヒー会員情報',$header, $body);
