<?php

class ProductController extends BaseController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function productAll()
    {
        $body = $this->request['QueryString'];

        $search = "where 1=1";
        if (!empty($body['search'])) {
            $key = conText($body['search']);
            $search = "where (name like '%{$key}%' or description like '%{$key}%' or price like '%{$key}%' or stock_quantity like '%{$key}%')";
        }

        $limit = "limit 5";
        if (!empty($body['limit'])) {
            $limit = "limit {$body['limit']}";
        }

        $products =  $this->getAll("select * from products {$search} order by created_at desc {$limit}");
        return ['status' => 200, 'msg' => '', 'data' => $products];
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
            return ['status' => 200, 'msg' => 'เพิ่มสินค้าใหม่เเล้ว..', 'data' => $newProduct];
        }
        return ['status' => 204, 'msg' => 'create product fail..'];
    }

    public function productDelete()
    {
        $body = $this->request['Ajax'];

        $productId = 0;
        if (!empty($body['productId'])) {
            $productId = conText($body['productId']);
        }

        $product = $this->trash('products', $productId);
        if ($product) {
            return ['status' => 200, 'msg' => 'ลบสินค้าสำเร็จ'];
        }
        return ['status' => 204, 'msg' => 'ลบสินค้าไม่สำเร็จ'];
    }

    public function productEdit()
    {
        $body = $this->request['QueryString'];

        $productId = 0;
        if (!empty($body['productId'])) {
            $productId = conText($body['productId']);
        }

        $product = $this->findOne('products', 'id = ?', [$productId]);
        if ($product) {
            $product = $this->exportAll($product);
            return ['status' => 200, 'msg' => '', 'data' => $product[0]];
        }
        return ['status' => 204, 'msg' => '', 'data' => $productId];
    }

    public function productUpdate()
    {
        $body = $this->request['Ajax']['formProduct'];

        $productId = conText($body['id']);
        $name = conText($body['name']);

        $product = $this->findOne('products', 'id = ?', [$productId]);
        if ($product) {
            $product = $this->load('products', $productId);
            $product->name = $name;
            $product->description = conText($body['description']);
            $product->price = conText($body['price']);
            $product->stock_quantity = conText($body['stock_quantity']);
            $this->store($product);
            $this->close();

            return ['status' => 200, 'msg' => 'เเก้ไขสินค้าสำเร็จ', 'data' => null];
        }
        return ['status' => 204, 'msg' => '', 'data' => null];
    }
}
