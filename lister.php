<?php
session_start();
require_once('master/prefix.php');

//ローカルのみ========================
$_SESSION['loginid']=10042;
$_SESSION['login_name']="武藤　一徳";
//====================================

//回覧メンバーに選ばれている回覧IDを検索する
$sql='select * from member where available=1';
$rst=selectData(DB_NAME,$sql);
$pname = array('会員名'=>'title','確認ボタン'=>'checker',date('n月')=>'status',date('n月',strtotime(date('Y-m-d').'-1 month'))=>'onepre',date('n月',strtotime(date('Y-m-d').'-2 month'))=>'twopre');

//表
$body .= '<table class="table table-bordered" style="width:580px;margin:0 0 0 30px;">';
$body .= '<tr>';
$body .= '<th rowspan="2">名前</th>';
$body .= '<th rowspan="2">支払確認</th>';
$body .= '<th colspan="3">支払済日</th>';
$body .= '</tr>';
$body .= '<tr>';

$body .= '<th>'.date('n月').'</th>';
$body .= '<th>'.date('n月',strtotime(date('Y-m-d').'-1 month')).'</th>';
$body .= '<th>'.date('n月',strtotime(date('Y-m-d').'-2 month')).'</th>';
$body .= '</tr>';

for($i=0;$i<count($rst);$i++){//指定されたuserIDのデータ全て
  $body .= '<tr>';
  $body .= '<td style="width:150px;nowrap;">'.nameFromUserID($rst[$i]['userID']).'</td>';
  $body .= '<td style="width:100px;nowrap;">';

  $sql='select * from checked where paydate >= "'.date('Y-m-').'01" and paydate <= "'.date('Y-m-').'31" and userID='.$rst[$i]['userID'];
  $rst_check=selectData(DB_NAME,$sql);  
  $sql='select * from member where userID='.$_SESSION['loginid'].' and voted=1';
  $rst_vote=selectData(DB_NAME,$sql);
  if($rst_vote[0]['voted']==1){
    if($rst_check[0]['paydate']==null){
      $body .= '<button name="'.$rst[$i]['userID'].'" class="havepay btn btn-success btn-xs">支払済</button>';
    }else{
      $body .= '<button name="'.$rst_check[0]['id'].'" class="paycancel btn btn-default btn-xs">キャンセル</button>';
    }
  }
  $body .= '</td>';

  $body .= '<td style="width:120px;nowrap;">';
  if($rst_check!=null){
    $body .= substr($rst_check[0]['paydate'],-2).'日(済)';
  }
  $body .= '</td>';

  $sql='select * from checked where paydate >= "'.date('Y-m-',strtotime(date('Y-m-d').'-1 month')).'01" and paydate <= "'.date('Y-m-',strtotime(date('Y-m-d').'-1 month')).'31" and userID='.$rst[$i]['userID'];
  $rst2=selectData(DB_NAME,$sql);
  $body .= '<td>';
  if($rst2!=null){
    $body .= substr($rst2[0]['paydate'],-2).'日(済)';
  }
  $body .= '</td>';

  $sql='select * from checked where paydate >= "'.date('Y-m-',strtotime(date('Y-m-d').'-2 month')).'01" and paydate <= "'.date('Y-m-',strtotime(date('Y-m-d').'-2 month')).'31" and userID='.$rst[$i]['userID'];
  $rst1=selectData(DB_NAME,$sql);
  $body .= '<td>';
  if($rst1!=null){
    $body .= substr($rst1[0]['paydate'],-2).'日(済)';
  }
  $body .= '</td>';
  $body .= '</tr>';
}
$body .= '</table>';

echo $body;
