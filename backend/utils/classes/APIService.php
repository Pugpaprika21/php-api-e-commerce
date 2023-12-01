<?php

class APIService
{
    public function setMethodAllowed($method = 'POST')
    {
        if ($_SERVER['REQUEST_METHOD'] != strtoupper($method)) {
            header('HTTP/1.1 405 Method Not Allowed');
            echo $this->setResponseJSON(['msg' => '405 Method Not Allowed'], 405);
            exit;
        }
    }

    public function setUnauthorized($key = "")
    {
        global $env;

        dump([$env['APP_API_KEY'], $key]);

        if ($env['APP_API_KEY'] != $key) {
            header('HTTP/1.1 401 Unauthorized');
            echo $this->setResponseJSON(['msg' => '401 Unauthorized'], 401);
            exit;
        }
    }

    public function setResponseJSON($arr, $statusCode = 200)
    {
        if (!empty($arr['status'])) {
            $statusCode = $arr['status'];
        }

        http_response_code($statusCode);
        return json_encode(['data' => arr_upr($arr)], JSON_UNESCAPED_UNICODE);
    }

    public function getRequest()
    {
        return array_merge([
            "Post" => $_POST,
            "Any" => $_REQUEST,
            "FormFile" => $_FILES,
            "QueryString" => $_GET,
            "Ajax" => json_decode(file_get_contents("php://input"), true)
        ]);
    }
}
