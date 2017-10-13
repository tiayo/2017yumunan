<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Repositories\CommodityRepository;
use App\Repositories\OrderRepository;
use App\Services\Manage\OrderService;
use App\Services\Manage\UserService;

class IndexController extends Controller
{
    public function index(OrderRepository $order, CommodityRepository $commodity)
    {
        return view('manage.index.index', [
            'avalidate' => $commodity->sumByStock(),
            'unavailable' => $order->sumByNum(),
            'order_count' => $order->countStatus(2),
            'lists' => $order->get(10),
        ]);
    }
}