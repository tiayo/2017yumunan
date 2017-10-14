<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\OrderCompletService;
use App\Services\Manage\RoomService;
use App\Services\Manage\CommodityService;
use App\Services\Manage\OrderService;
use Illuminate\Http\Request;

class OrderCompletController extends Controller
{
    protected $order_complet, $request;

    public function __construct(OrderCompletService $order_complet, Request $request)
    {
        $this->order_complet = $order_complet;
        $this->request = $request;
    }

    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($keyword = null)
    {
        $num = config('site.list_num');

        $orders = $this->order_complet->get($num, $keyword);

        return view('manage.order_complet.list', [
            'lists' => $orders,
        ]);
    }
}