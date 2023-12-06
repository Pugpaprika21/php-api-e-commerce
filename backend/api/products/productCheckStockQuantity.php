<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/products/ProductController.php");

$api->setMethodAllowed('get');
$api->setAuthorization();

$product = new ProductController($request);

write_log(__DIR__ . "../../../logs/requests/" . ProductController::class . ".txt", $request, $env['WRITE_LOG']);
echo $api->setResponseJSON($product->productCheckStockQuantity());
exit;
