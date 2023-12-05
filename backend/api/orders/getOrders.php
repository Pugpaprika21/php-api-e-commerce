<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/orders/OrdersController.php");

$api->setMethodAllowed('get');
$api->setUnauthorized($request['QueryString']['APP_API_KEY']);

$order = new OrdersController($request);

write_log($apps['log']['req'] . OrdersController::class . ".txt", $request, $env['WRITE_LOG']);
echo $api->setResponseJSON($order->getOrders());
exit;

