<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\AttributeRepository;
use App\Services\Manage\CommodityService;

class DetailController extends Controller
{
    protected $commodity;

    public function __construct(CommodityService $commodity)
    {
        $this->commodity = $commodity;
    }

    /**
     * 商品详情页视图
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        //获取当前商品信息
        $commodity = $this->commodity->first($id);

        return view('home.detail.detail', [
            'commodity' => $commodity,
        ]);
    }
}