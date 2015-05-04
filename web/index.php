<?php
require 'vendor/autoload.php';

$core = new \CommunityPi\Core;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$payload = $_POST;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$payload = $_GET;
}

$core->requestRouter($_SERVER['REQUEST_URI'], $payload);

?>
