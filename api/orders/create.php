<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/orders/OrdersController.php");

$api->setMethodAllowed();
$api->setUnauthorized();

$order = new OrdersController($request);

write_log(__DIR__ . "../../../logs/requests/" . $order::class . ".txt", $request, true);

echo $api->setResponseJSON($order->create());
exit;
