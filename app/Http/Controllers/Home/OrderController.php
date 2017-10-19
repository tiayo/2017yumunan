<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Manage\OrderService;
use App\Services\Manage\CommodityService;
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

    /**
     * 添加提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addPost($order_id = null)
    {
        $this->validate($this->request, [
            'commodity_id' => 'required|integer',
            'num' => 'required|integer',
            'day' => 'required|integer',
            'remark' => 'required',
            'status' => 'required|integer',
        ]);

        //添加时验证
        if (empty($order_id)) {
            $this->validate($this->request, [
                'id_number' => 'required',
                'phone' => 'required',
                'new_user' => 'integer',
            ]);
        }

        try {
            $this->order->updateOrCreate($this->request->all(), $order_id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('home.person');
    }
}