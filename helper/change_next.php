<?php
require_once('../master/prefix.php');

$sql = 'update member set next='.$_POST['set'].' where userID='.$_POST['userID'];
deleteFrom(DB_NAME,$sql);


