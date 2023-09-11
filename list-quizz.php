<?php
include 'temp/frag/header.php';
$sql = "SELECT * FROM `question` WHERE `id` = 2";
$param = [];

$question = requestSelect($sql, $param);



?>
<!-- Page du quizz -->
<main>
