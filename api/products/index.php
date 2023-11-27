<?php

header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

require_once(__DIR__ . "../../../includes/dependency.php");
require_once(__DIR__ . "../../../controllers/products/ProductController.php");

$api = new API();

$body = $api->setRequest();

$api->setMethodAllowed();
$api->setUnauthorized();

$product = new ProductController($body);

switch (conText($body['action_type'])) {
    case 'products':
        echo $api->setResponseJSON($product->productList());
        break;

    case 'get_all':
        echo $api->setResponseJSON(['name' => 'get_all']);
        break;

    default:
        echo $api->setResponseJSON(['msg' => 'no data..'], 204);
        break;
}
