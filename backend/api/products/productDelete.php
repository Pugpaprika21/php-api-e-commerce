<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/products/ProductController.php");

$api->setMethodAllowed('delete');
$api->setUnauthorized($request['Ajax']['APP_API_KEY']);

$product = new ProductController($request);

write_log(__DIR__ . "../../../logs/requests/" . ProductController::class . ".txt", $request, $env['WRITE_LOG']);
echo $api->setResponseJSON($product->productDelete());
exit;
