<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/users/UserController.php");

$api = new API();

$body = $api->setRequest();

$api->setMethodAllowed();
$api->setUnauthorized();

$user = new UserController($body);

write_log(__DIR__ . "../../../logs/requests/" . $user::class . ".txt", $body, $env['WRITE_LOG']);

echo $api->setResponseJSON($user->create());
exit;
