<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\CarService;
use App\Services\Home\IndexService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $index;

    public function __construct(IndexService $index)
    {
        $this->index = $index;
    }

    public function index()
    {
        //今日推荐
        $recommend_today = $this->index->getByType(0, 10);

        return view('home.index.index', [
            'recommend_today' => $recommend_today,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        if (empty($keyword)) {
            return view('home.index.search');
        }

        //记录到session
        $request->session()->push('search_keyword.', $keyword);

        //获取商品
        $commodities = $this->index->getSearch($keyword);

        return view('home.list.list', [
            'commodities' => $commodities,
        ]);
    }
}