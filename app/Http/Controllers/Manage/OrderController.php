<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\RoomService;
use App\Services\Manage\CommodityService;
use App\Services\Manage\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order, $request, $commodity;

    public function __construct(OrderService $order, Request $request, CommodityService $commodity)
    {
        $this->order = $order;
        $this->request = $request;
        $this->commodity = $commodity;
    }

    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($keyword = null)
    {
        $num = config('site.list_num');

        $orders = $this->order->get($num, $keyword);

        return view('manage.order.list', [
            'lists' => $orders,
        ]);
    }

    /**
     * 修改状态
     *
     * @param $order_id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($order_id, $status)
    {
        try {
            $this->order->changeStatus($order_id, $status);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('order_list');
    }

    /**
     * 修改管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        $commodities = $this->commodity->getSimple('*');

        return view('manage.order.add_or_update', [
            'commodities' => $commodities,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('order_add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 修改管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateView($id)
    {
        $commodities = $this->commodity->getSimple('*');

        try {
            $old_input = $this->order->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.order.add_or_update', [
            'commodities' => $commodities,
            'old_input' => $old_input,
            'url' => Route('order_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($order_id = null)
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

        return redirect()->route('order_list');
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        try {
            $this->order->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('order_list');
    }
}