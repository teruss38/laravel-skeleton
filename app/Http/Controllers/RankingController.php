<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

/**
 * 实时热点
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RankingController extends Controller
{
    /**
     * Show the ranking pages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('ranking.index');
    }

    /**
     * 查询关键词ID
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $word = Keyword::find($id);
        //TODO 调用搜索引擎，搜索这个词。
        return view('ranking.show');
    }
}
