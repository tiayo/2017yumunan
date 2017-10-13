<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\CommodityService;
use App\Services\Manage\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $room, $commodity;
    protected $request;

    public function __construct(RoomService $room, Request $request, CommodityService $commodity)
    {
        $this->room = $room;
        $this->request = $request;
        $this->commodity = $commodity;
    }

    /**
     * 记录列表
     *
     * @param null $keyword
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($keyword = null)
    {
        $num = config('site.list_num');

        $rooms = $this->room->get($num, $keyword);

        return view('manage.room.list', [
            'lists' => $rooms,
        ]);
    }

    /**
     * 添加视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        $commodities = $this->commodity->getSimple('*');

        return view('manage.room.add_or_update', [
            'commodities' => $commodities,
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('room_add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 修改管理员视图
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($id)
    {
        $commodities = $this->commodity->getSimple('*');

        try {
            $old_input = $this->request->session()->has('_old_input') ?
                session('_old_input') : $this->room->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.room.add_or_update', [
            'commodities' => $commodities,
            'old_input' => $old_input,
            'url' => Route('room_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'num' => 'required',
            'commodity_id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        try {
            $this->room->updateOrCreate($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('room_list');
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
            $this->room->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('room_list');
    }
}