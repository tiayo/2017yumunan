<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Repositories\CommodityRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RoomRepository;
use App\Services\Manage\OrderService;
use App\Services\Manage\UserService;

class IndexController extends Controller
{
    public function index(OrderRepository $order, RoomRepository $room)
    {
        return view('manage.index.index', [
            'avalidate' => $room->selectCount([['status', 1]]),
            'unavailable' => $room->selectCount([['status', 0]]),
            'order_count' => $order->countStatus(2),
            'lists' => $order->get(10),
        ]);
    }
}