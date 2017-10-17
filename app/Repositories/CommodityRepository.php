<?php

namespace App\Repositories;

use App\Commodity;

class CommodityRepository
{
    protected $commodity;

    public function __construct(Commodity $commodity)
    {
        $this->commodity = $commodity;
    }

    public function create($data)
    {
        return $this->commodity->create($data);
    }

    /**
     * 获取所有显示记录（带分页）
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num)
    {
        return $this->commodity
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取所有显示记录(简易)
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return $this->commodity
            ->select($select)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getValue($array)
    {
        $score = $this->commodity
            ->whereIn('id', $array)
            ->orderBy('id', 'desc')
            ->sum('score');

        $price = $this->commodity
            ->whereIn('id', $array)
            ->orderBy('id', 'desc')
            ->sum('price');

        return ['score' => $score, 'price' => $price];
    }

    /**
     * 获取显示的搜索结果（超级管理员级）
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($num, $keyword)
    {
        return $this->commodity
            ->where(function ($query) use ($keyword) {
                $query->where('commodities.name', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate($num);
    }
    
    public function first($id)
    {
        return $this->commodity->find($id);
    }

    public function superId()
    {
        return $this->commodity
            ->where('name', config('site.admin_name'))
            ->first();
    }

    public function destroy($id)
    {
        return $this->commodity
            ->where('id', $id)
            ->delete();
    }

    public function selectFirst($where, ...$select)
    {
        return $this->commodity
            ->select($select)
            ->where($where)
            ->first();
    }

    public function update($id, $data)
    {
        return $this->commodity
            ->where('id', $id)
            ->update($data);
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
        if ($type == 0) {
            return $this->commodity
                ->where('status', 1)
                ->where('type', '>=', $type)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        }

        return $this->commodity
            ->where('status', 1)
            ->where('type', $type)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * 随机获取查询
     *
     * @param $where
     * @param $num
     * @return mixed
     */
    public function randCommodity($where, $num, ...$select)
    {
        return $this->commodity
            ->select($select)
            ->where($where)
            ->inRandomOrder()
            ->limit($num)
            ->get();
    }

    public function getByCategory($category_id)
    {
        return $this->commodity
            ->where('category_id', $category_id)
            ->get();
    }

    /**
     * 获取多条记录（带where和select）
     *
     * @param $where
     * @param array ...$select
     * @return mixed
     */
    public function selectGet($where, ...$select)
    {
        return $this->commodity
            ->select($select)
            ->where($where)
            ->get();
    }
}