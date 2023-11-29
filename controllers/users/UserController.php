<?php

class UserController extends BaseController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function findById()
    {
        $body = $this->request['user'];

        $userId = conText($body['user_id']);
        $user = self::findOne('users', 'id = ?', [$userId]);

        if (!empty($user['id'])) {
            return ['status' => 200, 'msg' => 'find user successfully..', 'data' => $user];
        }

        return ['status' => 204, 'msg' => 'The user has no information.'];
    }

    public function create()
    {
        $body = $this->request['user'];

        $username = conText($body['username']);
        $email = conText($body['email']);

        $existingUser = self::findOne('users', 'username = ? OR email = ?', [$username, $email]);

        if ($existingUser) {
            return ['status' => 204, 'msg' => 'username or email is existing..'];
        }

        $user = self::dispense('users');
        $user->username = $username;
        $user->password = conText($body['password']);
        $user->first_name = conText($body['first_name']);
        $user->last_name = conText($body['last_name']);
        $user->email = $email;
        $user->address = conText($body['address']);
        $user->phone_number = conText($body['phone_number']);
        self::store($user);

        return ['status' => 200, 'msg' => 'create user successfully..'];
    }
}
