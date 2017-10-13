<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    /**
     * 获取所有显示记录
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num)
    {
        return $this->user
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取显示的搜索结果(模糊搜索)
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($num, $keyword)
    {
        return $this->user
            ->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', "%$keyword%")
                    ->orwhere('users.email', 'like', "%$keyword%")
                    ->orwhere('users.phone', 'like', "%$keyword%")
                    ->orwhere('users.id_number', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取显示的搜索结果(精确搜索)
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearchFirst($keyword)
    {
        return $this->user
            ->where('users.id_number', $keyword)
            ->first();
    }

    public function first($id)
    {
        return $this->user->find($id);
    }

    public function destroy($id)
    {
        //删除关联
        $this->user
            ->find($id)
            ->profile()
            ->delete();

        //删除user表
        return $this->user
            ->where('id', $id)
            ->delete();
    }

    public function selectFirst($where, ...$select)
    {
        return $this->user
            ->select($select)
            ->where($where)
            ->first();
    }

    public function update($id, $data)
    {
        return $this->user
            ->where('id', $id)
            ->update($data);
    }

    public function count($where)
    {
        return $this->user
            ->where($where)
            ->count();
    }
}