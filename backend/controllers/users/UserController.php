<?php

class UserController extends BaseController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function findUserById()
    {
        $body = $this->request['user'];

        $userId = conText($body['user_id']);
        $user = $this->findOne('users', 'id = ?', [$userId]);
        if ($user) {
            $user = $this->exportAll($user)[0];
            $this->close();
            return ['status' => 200, 'msg' => 'find user successfully..', 'data' => $user];
        }
        return ['status' => 204, 'msg' => 'The user has no information.'];
    }

    public function register()
    {
        $body = $this->request['Ajax']['formRegister'];

        $username = conText($body['username']);
        $password = conText($body['password']);
        $email = conText($body['email']);

        if ($this->findOne('users', 'username = ? OR password = ? OR email = ?', [$username, $password, $email])) {
            return ['status' => 204, 'msg' => 'username password or email is existing..'];
        }

        $user = $this->dispense('users');
        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 5]);
        $user->first_name = '';
        $user->last_name = '';
        $user->email = $email;
        $user->address = '';
        $user->phone_number = conText($body['phone_number']);
        $this->store($user);

        $role = $this->getAll("select id from roles where id = ? and active_status = ?", ['1', 'Y'])[0];

        $roleSett = $this->dispense('rolesetting');
        $roleSett->role_id = $role['id'];
        $roleSett->user_id = $user->id;
        $roleSett->active_status = 'Y';
        $this->store($roleSett);
        $this->close();

        return ['status' => 200, 'msg' => 'ลงทะเบียนสำเร็จ'];
    }

    public function login()
    {
        $body = $this->request['Ajax']['formLogin'];

        $username = conText($body['username']);
        $password = conText($body['password']);

        $user = $this->getAll("select * from users where username = ?", [$username]);
        if (!empty($user)) {
            if (password_verify($password, $user[0]['password'])) {
                return ['status' => 200, 'msg' => 'เข้าสู่ระบบสำเร็จ', 'data' => $user];
            }
        }
        return ['status' => 204, 'msg' => 'รหัสผ่านไม่ถูกต้อง'];
    }
}
