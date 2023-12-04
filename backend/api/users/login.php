<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/users/UserController.php");

$api->setMethodAllowed();
$api->setUnauthorized($request['Ajax']['APP_API_KEY']);

$user = new UserController($request);

write_log(__DIR__ . "../../../logs/requests/" . $user::class . ".txt", $request, $env['WRITE_LOG']);

echo $api->setResponseJSON($user->login());
exit;
