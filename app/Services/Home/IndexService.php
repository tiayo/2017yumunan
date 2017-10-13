<?php

namespace App\Services\Home;

use App\Repositories\RoomRepository;
use App\Repositories\CommodityRepository;

class IndexService
{
    protected $commodity;

    public function __construct(CommodityRepository $commodity)
    {
        $this->commodity = $commodity;
    }

    /**
     * 获取符合要求的商品
     *
     * @param $type
     * @param $limit
     * @return mixed
     */
    public function getByType($type, $limit)
    {
        return $this->commodity->getByType($type, $limit);
    }

    /**
     * 获取父级栏目
     * 
     * @return mixed
     */
    public function getCategoryParent()
    {
        return $this->category->getParent();
    }

    /**
     * 通过父级id获取下级
     *
     * @param $parent_id
     * @return mixed
     */
    public function getCategoryChildren($parent_id)
    {
        return $this->category->selectGet([
            ['parent_id', $parent_id],
        ], 'name', 'id');
    }

    /**
     * 搜索
     *
     * @param $keyword
     * @return mixed
     */
    public function getSearch($keyword)
    {
        return $this->commodity->selectGet([
            ['name', 'like', "%$keyword%"],
        ], '*');
    }
}