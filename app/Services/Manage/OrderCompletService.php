<?php

namespace App\Services\Manage;

use App\Repositories\CommodityRepository;
use App\Repositories\OrderCompletRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RoomRepository;
use App\Repositories\UserRepository;
use Exception;

class OrderCompletService
{
    protected $order_complet;

    public function __construct(
                                OrderCompletRepository $order_complet)
    {
        $this->order_complet = $order_complet;
    }

    /**
     * 获取需要的数据
     *
     * @param int $num
     * @param null $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num = 10000, $keyword = null)
    {
        if (!empty($keyword)) {
            return $this->order_complet->getSearch($keyword);
        }

        return $this->order_complet->get($num);
    }
}