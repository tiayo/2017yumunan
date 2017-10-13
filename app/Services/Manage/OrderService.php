<?php

namespace App\Services\Manage;

use App\Repositories\CommodityRepository;
use App\Repositories\OrderCompletRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RoomRepository;
use App\Repositories\UserRepository;
use Exception;

class OrderService
{
    protected $order, $user, $commodity, $room, $order_detail, $order_complet;

    public function __construct(OrderRepository $order,
                                UserRepository $user,
                                CommodityRepository $commodity,
                                RoomRepository $room,
                                OrderDetailRepository $order_detail,
                                OrderCompletRepository $order_complet)
    {
        $this->order = $order;
        $this->user = $user;
        $this->commodity = $commodity;
        $this->room = $room;
        $this->order_detail = $order_detail;
        $this->order_complet = $order_complet;
    }

    /**
     * 通过id验证记录是否存在以及是否有操作权限
     * 通过：返回该记录
     * 否则：抛错
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function validata($id)
    {
        $salesman = $this->order->first($id);

        throw_if(empty($salesman), Exception::class, '未找到该记录！', 404);

        return $salesman;
    }

    /**
     * 获取需要的数据
     *
     * @param int $num
     * @param null $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num = 10000, $order_id = null)
    {
        if (!empty($keyword)) {
            return $this->order->getSearch($order_id);
        }

        return $this->order->get($num);
    }

    /**
     * 获取需要的数据
     *
     * @param array ...$select
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return $this->order->getSimple(...$select);
    }

    /**
     * 修改状态
     *
     * @param $order_id
     * @param $status
     * @return mixed
     */
    public function changeStatus($order_id, $status)
    {
        //权限验证
        $order = $this->validata($order_id);

        //订单状态不能往低修改
        throw_if($status <= $order['status'], Exception::class, '您要修改的状态无效', 403);

        //判断订单状态是否可以修改

        //完成或取消时删除订单
        if($status == 2 || $status == 3) {
            $this->destroy($order_id, $status);
        }

        return $this->order->update($order_id, ['status' => $status]);
    }


    /**
     * 查找指定id的用户
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->validata($id);
    }

    /**
     * 更新或编辑
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function updateOrCreate($post, $id)
    {
        //获取数据
        $value = empty($id) ? $this->getUser($post) : $this->first($id);

        //判断订单是否可以操作
        if (!empty($id)) {
            throw_if($value['status'] == 2 || $value['status'] == 3, Exception::class, '该订单不可修改！', 403);
        }

        //商品信息
        $commodity = $this->commodity->first($post['commodity_id']);

        //判断房间是否足够
        $this->judgeRoom($post, $commodity, $id, $value);

        //订单组成数组
        $data['commodity_id'] = $post['commodity_id'];
        $data['num'] = $num = $post['num'];
        $data['day'] = $post['day'];
        $data['price'] = $commodity->price * $post['day'] * $post['num'];
        $data['status'] = $post['status'];
        $data['remark'] = $post['remark'];

        //添加时操作
        empty($id) ? $data['user_id'] = $value['id'] : true;

        //执行插入或更新
        empty($id) ? $id = $this->order->create($data)->id : $this->order->update($id, $data);

        //生成房间
        return $this->generateRoom($id);
    }

    /**
     * 生成房间
     *
     * @param $id
     * @return bool
     */
    public function generateRoom($id)
    {
        //找到房号
        $rooms = $this->order_detail->selectCount([['order_id', $id]]);

        //获取订单
        $num = $this->order->selectFirst([
            ['id', $id]
        ], 'num')['num'];

        //房间数并未修改
        if ($rooms == $num) {
            return true;
        }

        //房间需求减少
        if ($rooms > $num) {
           return $this->order_detail->destroyWhere(['order', $id], $rooms - $num);
        }

        //房间需求增长
        if ($rooms < $num) {
            //寻找空房
            $items = $this->room->selectGetLimit([
                ['status', 1]
            ], $num - $rooms, '*');

            foreach ($items as $item) {
                $this->order_detail->create([
                    'order_id' => $id,
                    'room_id' => $item['id'],
                ]);
            }

            return true;
        }

        return true;
    }

    /**
     * 判断空余房间是否足够
     *
     * @param $post
     * @param $commodity
     * @param $id
     * @param $value [更新前数据]
     * @return bool
     */
    public function judgeRoom($post, $commodity, $id, $value)
    {
        if (empty($id)) {
            throw_if($commodity->room->where('status', 1)->count() < $post['num'],
                Exception::class, '空余房间不足！', 403);
        } else {
            throw_if($commodity->room->where('status', 1)->count() + $value['num'] > $post['num'],
                Exception::class, '空余房间不足！', 403);
        }

        return true;
    }

    /**
     * 获取用户
     *
     * @param $post
     * @return int
     */
    public function getUser($post)
    {
        //查找用户(身份证)
        $user = $this->user->getSearchFirst($post['id_number']);

        //查找用户(手机)
        if (empty($user)) {
            $user = $this->user->getSearchFirst($post['phone']);
        }

        //未标记新用户时判断
        throw_if(!isset($post['new_user']) && empty($user), Exception::class, '未查询到用户', 403);

        if (empty($user)) {
            //创建会员
            $user = $this->user->create([
                'name' => '新用户-'.$post['phone'],
                'phone' => $post['phone'],
                'id_number' => $post['id_number'],
                'password' => bcrypt('888888'),
            ]);
        }

        return $user;
    }

    /**
     * 删除管理员
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id, $status = null)
    {
        //验证是否可以操作当前记录
        $value = $this->validata($id)->toArray();

        //获取订单删除前状态
        $status = empty($status) ? 3 : $status;

        //转移订单到订单结束表
        $this->order_complet->create($id, $status);

        //删除订单房间
        $this->order_detail->destroyWhere([
            ['order_id', $id]
        ], $value['num']);

        //执行删除
        return $this->order->destroy($id);
    }
}