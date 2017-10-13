<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\RoomRepository;
use App\Repositories\CommodityRepository;
use App\Services\Home\IndexService;
use App\Services\Manage\RoomService;

class ListController extends Controller
{
    protected $commodity, $category, $index;

    public function __construct(CommodityRepository $commodity,
                                RoomService $category,
                                IndexService $index)
    {
        $this->commodity = $commodity;
        $this->category = $category;
        $this->index = $index;
    }

    /**
     * 所欲分类目录
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryList()
    {

        return view('home.list.category', [
            'parents' => $this->category->getParent()
        ]);
    }

    /**
     * 分组目录
     *
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function group($type)
    {
        $commodities = $this->index->getByType($type, 100);

        return view('home.list.view', [
            'commodities' => $commodities,
        ]);
    }

    public function view($category_id)
    {
        $commodities = $this->commodity->getByCategory($category_id);

        return view('home.list.view', [
            'commodities' => $commodities,
        ]);
    }
}