<?php

namespace App\Http\Controllers\Home;

use App\Car;
use App\Http\Controllers\Controller;
use App\Services\Home\CarService;
use App\Services\Home\OrderService;
use App\Services\Manage\CommodityService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $order, $request, $commodity;

    public function __construct(OrderService $order, Request $request, CommodityService $commodity)
    {
        $this->order = $order;
        $this->request = $request;
        $this->commodity = $commodity;
    }

    public function addView($commodity_id)
    {
        $commodity = $this->commodity->first($commodity_id);

        $user = Auth::user();

        return view('home.order.add', [
            'user' => $user,
            'commodity' => $commodity,
        ]);
    }
}