<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * 前台文章
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends Controller
{
    /**
     * The response factory implementation.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * CodeController constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->middleware('auth')->except(['index', 'category', 'show', 'tag']);
        $this->response = $response;
    }

    /**
     * 列表页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Article::approved()->with('user')->orderByDesc('order')->orderByDesc('id')->paginate(15);
        $categories = Category::getRootNodes();
        return $this->response->view('article.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    /**
     * 文章Tag页
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function tag($id)
    {
        $tag = Tag::findOrFail($id);
        $items = $tag->articles()->with(['user', 'tags'])->paginate(15);
        return $this->response->view('article.tag', [
            'items' => $items,
            'tag' => $tag
        ]);
    }

    /**
     * 查看文章详情
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $this->authorize('show', $article);
        /*查看数+1*/
        $article->increment('views');

        $latestArticles = Article::latest(10);
        return $this->response->view('article.show', [
            'article' => $article,
            'latestArticles' => $latestArticles
        ]);
    }
}
