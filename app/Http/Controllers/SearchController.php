<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 搜索
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SearchController extends Controller
{

    /**
     * 搜索首页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * 搜索结果页
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function query(Request $request)
    {
        $q = $request->get('q');
        if (empty($q)) {
            return redirect(route('search'));
        }
        return view('search.query');
    }
}
