<?php
require_once('../master/prefix.php');

$sql = 'update member set voted=0';
deleteFrom(DB_NAME,$sql);

$sql = 'select userID from member where available=1';
$rst = selectData(DB_NAME,$sql);

$sql = 'update member set voted=1 where userID='.$rst[rand(0,(count($rst)-1))]['userID'];
deleteFrom(DB_NAME,$sql);

