<?php
require_once('../master/prefix.php');

$sql = 'delete from member where userID='.userIDFromName($_POST['name']);
deleteFrom(DB_NAME,$sql);


