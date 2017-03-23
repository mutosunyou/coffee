<?php
require_once('../master/prefix.php');

$sql = 'insert into member values (null,'.userIDFromName($_POST['name']).',1,0,1)';
deleteFrom(DB_NAME,$sql);


