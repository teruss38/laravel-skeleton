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
     * Display search page.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        if (!$request->has('q') || empty($request->get('q'))) {
            return view('search.index');
        }
        return $this->callAction('query', ['q' => $request->get('q')]);
    }

    /**
     * 搜索结果
     * @param string $q
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function query($q)
    {

        return view('search.list', ['items' => [], 'q' => $q]);
    }
}
