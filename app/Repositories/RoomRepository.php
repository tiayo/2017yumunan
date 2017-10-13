<?php

namespace App\Repositories;

use App\Room;

class RoomRepository
{
    protected $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    /**
     * 创建记录
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->room->create($data);
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
        return $this->room
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取所有显示顶级分类
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getParent()
    {
        return $this->room
            ->where('parent_id', 0)
            ->get();
    }

    /**
     * 获取所有显示记录(不带分页)
     *
     * @param array ...$select
     * @return mixed
     */
    public function getSimple(...$select)
    {
        return $this->room
            ->select($select)
            ->orderBy('id', 'desc')
            ->get();
    }
    
    /**
     * 获取显示的搜索结果
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($num, $keyword)
    {
        return $this->room
            ->where(function ($query) use ($keyword) {
                $query->where('categories.name', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取单条记录
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->room->find($id);
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->room
            ->where('id', $id)
            ->delete();
    }

    /**
     * 获取单条记录（带where和select）
     *
     * @param $where
     * @param array ...$select
     * @return mixed
     */
    public function selectFirst($where, ...$select)
    {
        return $this->room
            ->select($select)
            ->where($where)
            ->first();
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
        return $this->room
            ->select($select)
            ->where($where)
            ->get();
    }

    public function selectGetLimit($where, $limit, ...$select)
    {
        return $this->room
            ->select($select)
            ->where($where)
            ->limit($limit)
            ->get();
    }

    /**
     * 更新记录
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->room
            ->where('id', $id)
            ->update($data);
    }

    public function selectGetNum($where, $num, ...$select)
    {
        return $this->room
            ->select($select)
            ->where($where)
            ->limit($num)
            ->get();
    }
}