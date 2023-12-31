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

        $search = "WHERE 1=1";
        if (!empty($body['search'])) {
            $key = conText($body['search']);
            $search = "WHERE (name LIKE '%{$key}%' OR description LIKE '%{$key}%' OR price LIKE '%{$key}%' OR stock_quantity LIKE '%{$key}%')";
        }

        $limit = "LIMIT 1";
        if (!empty($body['limit'])) {
            $limit = "LIMIT {$body['limit']}";
        }

        $offset = "OFFSET 10";
        if (!empty($body['page'])) {
            $offset = "OFFSET {$body['page']}";
        }

        $total = $this->getAll("SELECT COUNT(*) AS total FROM products ORDER BY created_at DESC {$limit}")[0];
        
        $products = $this->getAll("SELECT * FROM products {$search} ORDER BY created_at DESC {$limit} {$offset}");

        return ['status' => 200, 'msg' => '', 'data' => $products, 'totalProduct' => $total];
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

    public function productCheckStockQuantity()
    {
        $body = $this->request['QueryString'];

        $productId = conText($body['productId']);
        $stockQuantity = conText($body['stockQuantity']);
        $totalAmount = conText($body['totalAmount']);

        $product = $this->findOne('products', 'id = ?', [$productId]);
        if ($product) {
            return ['status' => 200, 'msg' => '', 'data' => $product];
        }
        return ['status' => 400, 'msg' => 'Insufficient stock', 'data' => null];
    }
}
