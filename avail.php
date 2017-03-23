<?php
session_start();
require_once('../master/prefix.php');

$body='<div id="toggle" class="toggle-soft">';
$body.='<div class="toggle toggle-select" data-type="select"></div>';
$body.='</div>';

echo $body;
