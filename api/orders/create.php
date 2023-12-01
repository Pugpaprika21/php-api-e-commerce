<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/orders/OrdersController.php");

$api->setMethodAllowed();
$api->setUnauthorized();

$order = new OrdersController($request);

write_log(__DIR__ . "../../../logs/requests/" . $order::class . ".txt", $request, $env['WRITE_LOG']);

$response = $api->setResponseJSON($order->create());

write_log(__DIR__ . "../../../logs/response/" . $order::class . ".txt", $response, $env['WRITE_LOG']);
echo $response;
exit;
