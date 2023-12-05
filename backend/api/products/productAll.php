<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/products/ProductController.php");

$api->setMethodAllowed('get');
$api->setUnauthorized($request['QueryString']['APP_API_KEY']);

$product = new ProductController($request);

write_log($apps['log']['req'] . ProductController::class . ".txt", $request, $env['WRITE_LOG']);
echo $api->setResponseJSON($product->productAll());
exit;

