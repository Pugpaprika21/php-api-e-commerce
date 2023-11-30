<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/orders/OrdersController.php");

$api->setMethodAllowed();
$api->setUnauthorized();

$order = new OrdersController($request);

write_log(__DIR__ . "../../../logs/requests/" . $order::class . ".txt", $request, $env['WRITE_LOG']);

echo $api->setResponseJSON($order->ordersAll());
exit;
