<?php

namespace App\Services\Manage;

use App\Repositories\CommodityRepository;
use App\Services\ImageService;
use Exception;

class CommodityService
{
    use ImageService;

    protected $commodity;

    public function __construct(CommodityRepository $commodity)
    {
        $this->commodity = $commodity;
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
        $salesman = $this->commodity->first($id);

        throw_if(empty($salesman), Exception::class, '未找到该记录！', 404);

        return $salesman;
    }

    /**
     * 获取需要的数据
     *
     * @return mixed
     */
    public function get($num = 10000, $keyword = null)
    {
        if (!empty($keyword)) {
            return $this->commodity->getSearch($num, $keyword);
        }

        return $this->commodity->get($num);
    }

    /**
     * 获取需要的数据
     *
     * @param array ...$select
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return $this->commodity->getSimple(...$select);
    }

    /**
     * 获取数组内记录的总积分、总价格
     *
     * @param $array
     * @return array
     */
    public function getValue($array)
    {
        return $this->commodity->getValue($array);
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
     * 改变状态
     *
     * @param $commodity_id
     * @return mixed
     */
    public function changeStatus($commodity_id)
    {
        //验证和获取数据
        $commodity = $this->validata($commodity_id);

        //更新数组
        $data['status'] = $commodity['status'] == 1 ?  0 : 1;

        //进行更新
        return $this->commodity->update($commodity_id, $data);
    }

    /**
     * 更新或编辑
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function updateOrCreate($post, $id = null)
    {
        //统计数据
        $data['name'] = $post['name'];
        $data['price'] = $post['price'];
        $data['description'] = $post['description'];
        $data['type'] = $post['type'];

        //执行插入或更新
        return empty($id) ? $this->commodity->create($data) : $this->commodity->update($id, $data);
    }

    /**
     * 处理图片上传
     *
     * @param $post
     * @param $commodity_id
     * @return bool
     */
    public function uploadImagePost($post, $commodity_id)
    {
        for ($i=0; $i<9; $i++) {
            if (empty($post['image_'.$i])) {
                continue;
            }

            $data['image_'.$i] = $this->uploadImage($post['image_'.$i]);
        }

        if (!isset($data)) {
            return false;
        }

        return $this->commodity->update($commodity_id, $data);
    }

    /**
     * 删除管理员
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        //验证是否可以操作当前记录
        $this->validata($id)->toArray();

        //执行删除
        return $this->commodity->destroy($id);
    }

    public function randCommodity()
    {
        return $this->commodity->randCommodity([
            ['status', 1],
        ], 5, 'id', 'image_0');
    }
}