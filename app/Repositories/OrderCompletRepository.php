<?php

namespace App\Repositories;

use App\Order;
use App\OrderComplet;
use Illuminate\Support\Facades\Auth;

class OrderCompletRepository
{
    protected $order, $orderComplet;

    public function __construct(Order $order, OrderComplet $orderComplet)
    {
        $this->order = $order;
        $this->orderComplet = $orderComplet;
    }

    public function create($order_id, $status)
    {
        //获取原订单
        $order = $this->order->find($order_id);

        $room = null;

        //获取房间号
        foreach($order->orderDetail as $key => $detail) {
            $room .= $detail->room->num.'|';
        }

        $order = $order->toArray();
        $order['room'] = rtrim($room, '|');
        $order['status'] = $status;

        //创建
        return $this->orderComplet->create($order);
    }

    /**
     * 获取所有显示记录（带分页）
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num)
    {
        return $this->orderComplet
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取显示的搜索结果
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($keyword)
    {
        return $this->orderComplet
            ->join('users', 'order_complets.user_id', 'users.id')
            ->where('order_complets.id', $keyword)
            ->orwhere('users.name', $keyword)
            ->orwhere('users.phone', $keyword)
            ->orwhere('users.email', $keyword)
            ->orwhere('users.id_number', $keyword)
            ->paginate(config('site.list_num'));
    }

}