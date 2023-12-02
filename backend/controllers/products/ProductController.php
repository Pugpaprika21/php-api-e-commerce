<?php

class ProductController extends BaseController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function productCreate()
    {
        $body = $this->request['Ajax']['formProduct'];

        $product = $this->dispense('products');

        $name = conText($body['name']);

        $existingProduct = $this->findOne('products', 'username = ?', [$name]);
        
        if ($existingProduct) {
            return ['status' => 204, 'msg' => 'product name is existing..'];
        }

        $product->name = $name;
        $product->description = conText($body['description']);
        $product->price = conText($body['price']);
        $product->stock_quantity = conText($body['stock_quantity']);
        $this->store($product);
        $this->close();

        $product = $this->findOne('products', 'id = ?', [$product->id]);

        if ($product) {
            $newProduct = $this->exportAll($product)[0];
            return ['status' => 200, 'msg' => 'create product successfully..', 'data' => $newProduct];
        }
        return ['status' => 204, 'msg' => 'create product fail..'];
    }
}
