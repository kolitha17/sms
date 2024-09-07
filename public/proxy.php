<?php
$empno = $_GET['empno'];
$url = "https://survey.gov.lk/hrdb/api_sms.php?empno=$empno";

$response = file_get_contents($url);
header('Content-Type: application/json');
echo $response;
?>