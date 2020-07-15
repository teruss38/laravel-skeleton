<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * 内容
 *
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
        $items = Article::accepted()->with('user')
            ->orderByDesc('order')
            ->orderByDesc('id')
            ->paginate(15);
        $categories = ArticleCategory::query()->get();
        $recommendedArticles = Article::recommended();
        return $this->response->view('article.index', [
            'items' => $items,
            'categories' => $categories,
            'category_title' => trans('Articles'),
            'category_description' => trans('Articles'),
            'category_id' => null,
            'recommendedArticles' => $recommendedArticles
        ]);
    }

    /**
     * 文章Tag页
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function tag($id)
    {
        if (($tag = Tag::findById($id)) != null) {
            $items = $tag->articles()->with(['user', 'tags'])->paginate(15);
            return $this->response->view('article.tag', [
                'items' => $items,
                'tag' => $tag
            ]);
        }
        throw (new ModelNotFoundException)->setModel(
            Tag::class, $tag
        );
    }

    /**
     * 栏目列表页
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function category($category_id)
    {
        $category = ArticleCategory::query()->findOrFail($category_id);
        $items = Article::accepted()->byCategoryId($category_id)->orderByDesc('id')->paginate(15);
        $categories = ArticleCategory::query()->get();
        $recommendedArticles = Article::recommended();
        return $this->response->view('article.index', [
            'items' => $items,
            'categories' => $categories,
            'category_title' => $category->title,
            'category_description' => $category->description,
            'category_id' => $category_id,
            'recommendedArticles' => $recommendedArticles
        ]);
    }

    /**
     * 发布文章
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Article::class);
        $categories = ArticleCategory::query()->get();
        return $this->response->view('article.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * 发布文章
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request)
    {
        $requestData = $request->validated();
        $requestData['user_id'] = $request->user()->id;
        $article = Article::create($requestData);
        if ($article) {
            $message = '文章发布成功！为了确保文章的质量，我们会对您发布的文章进行审核。请耐心等待......';
            return redirect()->route('article.show', ['id' => $article->id])->with(['message' => $message]);
        }
        return redirect()->back()->withErrors('文章发布失败，请稍后再试!');
    }

    /**
     * 查看文章详情
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $article = Article::query()->findOrFail($id);
        $this->authorize('show', $article);
        /*查看数+1*/
        $article->increment('views');
        $recommendedArticles = Article::recommended();
        return $this->response->view('article.show', [
            'article' => $article,
            'recommendedArticles' => $recommendedArticles
        ]);
    }
}
