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
 * 用户主页
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SpaceController extends Controller
{
    /**
     * Display space page.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        if (!$request->has('q')) {
            return view('space.index');
        }
        return view('space.index');
    }
}
