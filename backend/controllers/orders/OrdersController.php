<?php

class OrdersController extends BaseController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function createOrders()
    {
        $body = $this->request['Ajax']['formOrders'];

        $totalAmount = 0;
        $userId = conText($body['userId']);
        if (count($body['orders']) > 0) {
            foreach ($body['orders'] as $orderVal) {
                $totalAmount += $orderVal['totalAmount'];
            }
            $order = $this->dispense('orders');
            $order->user_id = $userId;
            $order->order_date = date('Y-m-d');
            $order->total_amount = $totalAmount;
            $order->order_status = 'Pending';
            $this->store($order);

            if ($order->id) {
                foreach ($body['orders'] as $orderVal) {
                    $orderItem = $this->dispense('orderitems');
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $orderVal['productId'];
                    $orderItem->quantity = $orderVal['totalAmount'];
                    $unitPrice = ($orderVal['totalAmount'] / $orderVal['stockQuantity']);
                    $orderItem->unit_price = $unitPrice;
                    $orderItem->subtotal = ($unitPrice * $orderVal['stockQuantity']);
                    $this->store($orderItem);
                }
            }
            $this->close();

            return ['status' => 200, 'msg' => 'เพิ่มรายการสั่งซื้อสำเร็จ'];
        }
        return ['status' => 200, 'msg' => 'ทำรายการสั่งซื้อไม่สำเร็จ'];
    }

    public function getOrders()
    {
        $body = $this->request['QueryString'];
        
        $userId = conText($body['userId']);

        $totalOrder = $this->getCell("
            SELECT COUNT(*) AS totalOrder
            FROM orders
            INNER JOIN orderitems ON orders.id = orderitems.order_id
            WHERE orders.user_id = ?",
            [$userId]
        );

        return ['status' => 200, 'msg' => '', ['totalOrders' => $totalOrder]];
    }
}
