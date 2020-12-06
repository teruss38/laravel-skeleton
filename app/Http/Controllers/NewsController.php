<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\News;

/**
 * 快讯
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NewsController extends Controller
{
    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the news.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $items = News::query()->orderByDesc('order')->orderByDesc('id')->paginate(15);
        return view('news.index', [
            'items' => $items
        ]);
    }

    /**
     * Display the specified news.
     *
     * @param \App\Models\News $news
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(News $news)
    {
        /*查看数+1*/
        $news->increment('views');
        return view('news.show', [
            'news' => $news
        ]);
    }

    /**
     * Remove the specified news from storage.
     *
     * @param \App\Models\News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index');
    }
}
