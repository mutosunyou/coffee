<?php
require_once('../master/prefix.php');

$sql = 'delete from checked where id='.$_POST['id'];
deleteFrom(DB_NAME,$sql);
var_dump($sql);

