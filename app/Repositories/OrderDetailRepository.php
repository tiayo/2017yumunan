<?php

namespace App\Repositories;

use App\OrderDetail;
use App\Room;

class OrderDetailRepository
{
    protected $orderDetail, $room;

    public function __construct(OrderDetail $orderDetail, Room $room)
    {
        $this->orderDetail = $orderDetail;
        $this->room = $room;
    }

    /**
     * 创建记录
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        //将房间改为不可用
        $this->room
            ->where('id', $data['room_id'])
            ->update(['status' => 0]);

        return $this->orderDetail->create($data);
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        //获取要删除的条目
        $order_detail = $this->room->find($id);

        //将房间改为可用
        $this->room
            ->where('id', $order_detail['room_id'])
            ->update(['status' => 1]);

        //删除订单详细记录
        return $this->orderDetail
            ->where('id', $id)
            ->delete();
    }

    public function destroyWhere($where, $limit)
    {
        //获取要删除的 $limit 条信息
        $order_details = $this->orderDetail
            ->where($where)
            ->limit($limit)
            ->get();

        //将房间改为可用
        foreach ($order_details as $order_detail) {
            $this->room
                ->where('id', $order_detail['room_id'])
                ->update(['status' => 1]);
        }

        //提交删除
        foreach ($order_details as $order_detail) {
            return $this->orderDetail
                ->where('order_id', $order_detail['order_id'])
                ->delete();
        }
    }

    public function selectCount($where)
    {
        return $this->orderDetail
            ->where($where)
            ->count();
    }
}
