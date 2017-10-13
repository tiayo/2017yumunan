<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\CommodityService;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    protected $commodity;
    protected $request;


    public function __construct(CommodityService $commodity, Request $request)
    {
        $this->commodity = $commodity;
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

        $commoditys = $this->commodity->get($num, $keyword);

        return view('manage.commodity.list', [
            'lists' => $commoditys,
        ]);
    }

    /**
     * 添加管理员视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        return view('manage.commodity.add_or_update', [
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('commodity_add'),
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
        try {
            $old_input = $this->request->session()->has('_old_input') ?
                session('_old_input') : $this->commodity->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.commodity.add_or_update', [
            'old_input' => $old_input,
            'url' => Route('commodity_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'type' => 'required|integer',
        ]);

        //创建动作时验证邮箱是否已经存在
        empty($id) ? $this->validate($this->request, [
            'name' => 'unique:commodities'
        ]) : true;

        try {
            $this->commodity->updateOrCreate($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('commodity_list');
    }

    /**
     * 上传商品图片 视图
     *
     * @param $commodity_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadImage($commodity_id)
    {
        $commodity = $this->commodity->first($commodity_id);

        return view('manage.commodity.upload_image', [
            'commodity' => $commodity,
            'url' => Route('commodity_image', ['id' => $commodity_id]),
        ]);
    }

    /**
     * 上传商品图片 处理
     *
     * @param $commodity_id
     * @return $this
     */
    public function uploadImagePost($commodity_id)
    {
        try {
            $this->commodity->uploadImagePost($this->request->all(), $commodity_id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('commodity_image', ['id' => $commodity_id]);
    }

    /**
     * 修改商品状态
     *
     * @param $commodity_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($commodity_id)
    {
        try{
            $this->commodity->changeStatus($commodity_id);
        } catch (\Exception $e) {
            return redirect()->route('commodity_list')->withErrors($e->getMessage());
        }

        return redirect()->route('commodity_list');
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
            $this->commodity->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('commodity_list');
    }
}