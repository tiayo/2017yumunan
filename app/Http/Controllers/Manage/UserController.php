<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Manage\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $request;

    public function __construct(UserService $user, Request $request)
    {
        $this->user = $user;
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

        $categories = $this->user->get($num, $keyword);

        return view('manage.user.list', [
            'lists' => $categories,
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
                session('_old_input') : $this->user->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('manage.user.add_or_update', [
            'old_input' => $old_input,
            'url' => Route('user_update', ['id' => $id]),
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
            'email' => 'required|email',
            'id_number' => 'required',
            'status' => 'required|integer|min:0|max:1',
            'avatar' => 'file|image',
            'password' => 'min:6',
        ]);

        try {
            $this->user->update($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('user_list');
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
            $this->user->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('user_list');
    }
}