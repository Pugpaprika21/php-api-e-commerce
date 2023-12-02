<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/orders/OrdersController.php");

$api->setMethodAllowed();
$api->setUnauthorized($request['Ajax']['APP_API_KEY']);

$order = new OrdersController($request);

write_log(__DIR__ . "../../../logs/requests/" . OrdersController::class . ".txt", $request, $env['WRITE_LOG']);
echo $api->setResponseJSON($order->ordersAll());
exit;
