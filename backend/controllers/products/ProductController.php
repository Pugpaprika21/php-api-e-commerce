<?php

class ProductController extends R
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function productList()
    {
        $body = $this->request['user'];
        //$product = self::getAll("select * from product");

        return array(
            'name' => 'phone',
            'price' => 5000,
            $body
        );
    }
}
