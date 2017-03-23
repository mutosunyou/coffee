<?php
require_once('../master/prefix.php');

$sql = 'insert into checked values (null,'.$_POST['id'].',"'.date('Y-m-d').'")';
deleteFrom(DB_NAME,$sql);


