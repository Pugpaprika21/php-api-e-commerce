<?php

class ProductController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function productList()
    {
        return array(
            'name' => 'phone',
            'price' => 5000,
        );
    }
}
