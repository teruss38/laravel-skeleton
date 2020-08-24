<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Locoy\CreateArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;

/**
 * 火车采集器接口
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LocoyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.locoy');
    }

    /**
     * 获取所有文章栏目
     */
    public function articleCategories()
    {
        $categories = ArticleCategory::query()->get();
        $res = '';
        foreach ($categories as $category) {
            $res .= '<<<' . $category->id . '--' . $category->title . '>>>';
        }
        return $res;
    }

    /**
     * 文章发布
     * @param CreateArticleRequest $request
     * @return string
     */
    public function storeArticle(CreateArticleRequest $request)
    {
        $requestData = $request->validated();
        $article = Article::create($requestData);
        if ($article) {
            return '发布成功';
        } else {
            return '发布失败';
        }
    }
}
