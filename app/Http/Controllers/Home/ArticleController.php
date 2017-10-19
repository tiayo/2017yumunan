<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Manage\ArticleService;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(ArticleService $article)
    {
        $this->article = $article;
    }

    public function listView()
    {
        $articles = $this->article->getSimple('*');

        return view('home.article.list', [
            'lists' => $articles,
        ]);
    }

    public function articleView($article_id)
    {
        $article = $this->article->first($article_id);

        return view('home.article.article', [
            'article' => $article,
        ]);
    }
}