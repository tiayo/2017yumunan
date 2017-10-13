<?php

namespace App\Services\Home;

use App\Repositories\CommodityRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Exception;

class OrderService
{
    protected $order, $orderDetail, $commodity;

    public function __construct(OrderRepository $order,
                                CommodityRepository $commodity)
    {
        $this->order = $order;
        $this->commodity = $commodity;
    }

    public function add()
    {
        throw_if(empty(Auth::user()['address']) || empty(Auth::user()['phone']), Exception::class, '您没有地址和电话！');

        //获取当前用户购物车所有商品
        $cars = $this->car->get();

        //构造订单
        $order['user_id'] = Auth::id();
        $order['name'] = Auth::user()['name'];
        $order['address'] = Auth::user()['address'];
        $order['phone'] = Auth::user()['phone'];
        $order['price'] = $this->car->total_price($cars);
        $order['type'] = 1;
        $order['status'] = 1; //测试：默认为已付款

        //创建订单
        $id = $this->order->create($order)->id;

        //创建订单详情以及减少库存
        foreach ($cars as $car) {
            //减少库存操作
            $this->commodity->decrement($car['num']);

            //订单详情数据
            $order_detail['order_id'] = $id;
            $order_detail['user_id'] = $car['user_id'];
            $order_detail['commodity_id'] = $car['commodity_id'];
            $order_detail['num'] = $car['num'];
            $order_detail['price'] = $car['price'];
            $order_detail['remark'] = $car['remark'];
            $order_detail['status'] = $car['status'];

            //写入订单详情数据库
            $this->orderDetail->create($order_detail);

            //删除购物车
            $this->car->destroy($car['id']);
        }

        return true;
    }

    /**
     * 获取符合条件的订单
     *
     * @param null $status
     * @return mixed
     */
    public function get($status = null)
    {
        if (empty($status)) {
            return $this->order->getByUserAll();
        }

        return $this->order->getByUser($status);
    }

    /**
     * 通过id验证记录是否存在以及是否有操作权限
     * 通过：返回该记录
     * 否则：抛错
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function validata($id)
    {
        $first = $this->order->first($id);

        throw_if(empty($first), Exception::class, '未找到该记录！', 404);

        throw_if(!can('control', $first), Exception::class, '没有权限！', 403);

        return $first;
    }

    /**
     * 通过id获取单条订单
     *
     * @param $id
     * @return OrderService|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static[]
     */
    public function first($id)
    {
        return $this->validata($id);
    }
}