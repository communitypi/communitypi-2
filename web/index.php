<?php
require_once 'includes/CommunityPi.class.php';

$communitypi = new CommunityPi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$payload = $_POST;
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$payload = $_GET;
}

$communitypi->request_router($_SERVER['REQUEST_URI'], $payload);

?>
