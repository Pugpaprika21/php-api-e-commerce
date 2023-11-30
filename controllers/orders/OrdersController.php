<?php

class OrdersController extends BaseController
{
    private $request;

    public function __construct($body)
    {
        $this->request = $body;
    }

    public function ordersAll()
    {
        $orders = $this->exportAll($this->findAll('orders', 'ORDER BY created_at DESC'));
        if (count($orders) > 0) {
            return ['status' => 200, 'data' => $orders];
        }
        return ['status' => 204, 'data' => $orders];
    }

    public function create()
    {
        $body = $this->request['order'];

        $userId = conText($body['user_id']);

        $user = $this->findOne('users', 'id = ?', [$userId]);
        if ($user) {
            $order = $this->dispense('orders');
            $order->user_id = $userId;
            $order->order_date = date('Y-m-d');
            $order->total_amount = conText($body['total_amount']);
            $this->store($order);
            $this->close();

            $newOrder = $this->exportAll($this->findOne('orders', 'id = ?', [$order->id]))[0];

            return ['status' => 200, 'msg' => 'create order successfully..', 'data' => $newOrder];
        }
        return ['status' => 204, 'msg' => 'user order not found..'];
    }
}
