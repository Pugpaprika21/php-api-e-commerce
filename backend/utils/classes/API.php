<?php

class API
{
    private $request;
    private $type;
    private $debug = false;
    private $header = false;
    private $user = false;
    private $urlGet = false;
    private $rows = false;

    public function setDebug($data)
    {
        $this->debug = $data;
    }

    public function setGet($data)
    {
        $this->urlGet = $data;
    }

    public function getToken($name = "Authorization")
    {
        $this->header = apache_request_headers();
        return $this->header[$name] ?? null;
    }

    public function getAuthen()
    {
        $this->user = [
            "username" => $_SERVER['PHP_AUTH_USER'] ?? null,
            "password" => $_SERVER['PHP_AUTH_PW'] ?? null
        ];
        return $this->user;
    }

    public function setRequest()
    {
        $this->parseRequestData();

        return array_merge($this->request, [
            'QueryString' => $_GET,
            'FormFile' => $_FILES
        ]);
    }

    private function parseRequestData()
    {
        $str = file_get_contents("php://input");

        if ($this->isJson($str) && $str) {
            $this->request = json_decode($str, true);
            $this->type = 'json';
        } elseif (preg_match('/form-data;/', $str)) {
            $this->request = [];
            $this->parseRawHttpRequest($this->request);
            $this->type = 'form-data';
        } elseif (preg_match("~([^&]+)=([^&]+)~", $str)) {
            parse_str($str, $this->request);
            $this->type = 'urlencode';
        } elseif ($_POST) {
            $this->request = $_POST;
            $this->type = 'POST';
        } elseif ($_GET) {
            $this->request = $_GET;
            $this->type = '_GET';
        }

        if ($_GET && $this->urlGet) {
            $this->request = array_merge($this->request, $_GET);
        }
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getType()
    {
        return $this->type;
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function parseRawHttpRequest(array &$data)
    {
        $input = file_get_contents('php://input');
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        $boundary = $matches[1];
        $blocks = preg_split("/-+$boundary/", $input);
        array_pop($blocks);
        foreach ($blocks as $id => $block) {
            if (empty($block)) {
                continue;
            }
            preg_match(
                strpos($block, 'application/octet-stream') !== false
                    ? "/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s"
                    : '/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s',
                $block,
                $matches
            );
            $data[$matches[1]] = $matches[2];
        }
    }

    public function setError($arr, $message)
    {
        return $this->response(false, $arr, $message);
    }

    public function setResponse($arr, $message)
    {
        return $this->response(true, arr_upr($arr), $message);
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    private function response($type, $arr, $message)
    {
        $response = [
            'status' => $type,
            'message' => $message
        ];
        if ($arr) {
            $response['data'] = $arr;
        }
        if ($this->rows) {
            $response['rows'] = $this->rows;
        }
        if ($this->debug) {
            $response += [
                'request' => $this->request,
                'type' => $this->type,
                'header' => $this->header,
                'user' => $this->user
            ];
        }
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function setResponseJSON($arr, $statusCode = 200)
    {
        if (!empty($arr['status'])) {
            $statusCode = $arr['status'];
        }

        http_response_code($statusCode);
        return json_encode(['data' => arr_upr($arr)], JSON_UNESCAPED_UNICODE);
    }

    public function setMethodAllowed($method = 'POST')
    {
        if ($_SERVER['REQUEST_METHOD'] != strtoupper($method)) {
            header('HTTP/1.1 405 Method Not Allowed');
            echo $this->setResponseJSON(['msg' => '405 Method Not Allowed'], 405);
            exit;
        }
    }

    public function setUnauthorized()
    {
        global $env, $request;

        if ($env['APP_API_KEY'] != conText($request['APP_API_KEY'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo $this->setResponseJSON(['msg' => '401 Unauthorized'], 401);
            exit;
        }
    }
}
