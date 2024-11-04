<?php
$empno = $_GET['empno'];
$url = "";

$response = file_get_contents($url);
header('Content-Type: application/json');
echo $response;
?>