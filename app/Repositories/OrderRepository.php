<?php

namespace App\Repositories;

use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create($data)
    {
        return $this->order->create($data);
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
        return $this->order
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取所有显示记录(简易)
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return $this->order
            ->select($select)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getByUserAll()
    {
        return $this->order
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getByUser($status)
    {
        return $this->order
            ->where('user_id', Auth::id())
            ->where('status', $status)
            ->orderBy('id', 'desc')
            ->get();
    }
    
    /**
     * 获取显示的搜索结果
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($order_id)
    {
        return $this->order
            ->where('id', $order_id)
            ->get();
    }
    
    public function first($id)
    {
        return $this->order->find($id);
    }

    public function destroy($id)
    {
        return $this->order
            ->where('id', $id)
            ->delete();
    }

    public function selectFirst($where, ...$select)
    {
        return $this->order
            ->select($select)
            ->where($where)
            ->first();
    }

    public function update($id, $data)
    {
        return $this->order
            ->where('id', $id)
            ->update($data);
    }

    public function countStatus($status)
    {
        return $this->order
            ->where('status', $status)
            ->count();
    }
}