<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\OrderService;
use App\Services\ImageService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    use ImageService;

    protected $order, $request;

    public function __construct(OrderService $order, Request $request)
    {
        $this->order = $order;
        $this->request = $request;
    }

    public function view()
    {
        //全部
        $orders_all = $this->order->get();

        //待发货
        $orders_1 = $this->order->get(1);

        //已完成
        $orders_2 = $this->order->get(2);

        return view('home.person.view', [
            'orders_all' => $orders_all,
            'orders_1' => $orders_1,
            'orders_2' => $orders_2,
        ]);
    }

    /**
     * 更新用户信息 视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update()
    {
        return view('home.person.update', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * 更新用户信息 post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePost()
    {
        //提交的内容
        $post = $this->request->all();

        //原内容
        $user = Auth::user();

        //更新数组
        $data['name'] = $post['name'] ?? $user['name'];
        $data['phone'] = $post['phone'] ?? $user['phone'];
        $data['address'] = $post['address'] ?? $user['address'];

        //有更新头像时执行
        if (isset($post['avatar']) && !empty($post['avatar'])) {
            $data['avatar'] = $this->uploadImage($post['avatar']) ?? $user['avatar'];
        }

        User::where('id', Auth::id())->update($data);

        return redirect()->route('home.person');
    }
}