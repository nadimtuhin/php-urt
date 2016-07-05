<?php 
require (__DIR__.'/../bootstrap.php');

use Symfony\Component\HttpFoundation\JsonResponse;

$data = getUrtServerStatus($host, $port, $connectionTimeout);
$response = new JsonResponse();
$response->setData($data);
@$response->send();
