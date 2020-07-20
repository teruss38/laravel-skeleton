<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Article\CreateArticleRequest;
use App\Http\Requests\Api\V1\Article\UpdateArticleRequest;
use App\Http\Resources\Api\V1\Article\ArticleResource;
use App\Http\Resources\Api\V1\Article\ArticleBaiduSmartProgramSitemapResource;
use App\Http\Resources\Api\V1\Article\CategoryResource;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

/**
 * 文章接口
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'sitemap', 'category', 'show']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $items = Article::accepted()->orderByDesc('id')->paginate(15);
        return ArticleResource::collection($items);
    }

    /**
     * sitemap
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function sitemap(Request $request)
    {
        $items = Article::accepted()->orderByDesc('id')->paginate(100);
        return ArticleBaiduSmartProgramSitemapResource::collection($items);
    }

    /**
     * 获取所有的栏目
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function category()
    {
        $categories = ArticleCategory::query()->get();
        return CategoryResource::collection($categories);
    }

    /**
     * 我发布的文章
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function my(Request $request)
    {
        $items = Article::query()->where('user_id', '=', $request->user()->id)->orderByDesc('id')->paginate(15);
        return ArticleResource::collection($items);
    }

    /**
     * 文章发布
     * @param CreateArticleRequest $request
     * @return ArticleResource
     */
    public function store(CreateArticleRequest $request)
    {
        $requestData = $request->validated();
        $requestData['user_id'] = $request->user()->id;
        $article = Article::create($requestData);
        return new ArticleResource($article);
    }

    /**
     * 更新文章
     *
     * @param CreateArticleRequest $request
     * @param int $id
     * @return ArticleResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::query()->where('id', $id)->firstOrFail();
        $this->authorize('update', $article);
        $article->update($request->validated());
        return new ArticleResource($article);
    }

    /**
     * 查看文章内容
     * @param int $id
     * @return ArticleResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $article = Article::query()->findOrFail($id);
        $this->authorize('show', $article);
        /*查看数+1*/
        $article->increment('views');
        return new ArticleResource($article);
    }

    /**
     * 文章删除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $article = Article::query()->where('id', $id)->firstOrFail();
        $this->authorize('destroy', $article);
        return $this->withNoContent();
    }
}
