<?php

require(__DIR__ . "../../../includes/dependency.php");
require(__DIR__ . "../../../controllers/users/UserController.php");

$api->setMethodAllowed('GET');
$api->setUnauthorized();

$user = new UserController($request);

write_log(__DIR__ . "../../../logs/requests/" . $user::class . ".txt", $request, true);

echo $api->setResponseJSON($user->findUserById());
exit;
