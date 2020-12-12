<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

/**
 * 下载页面
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DownloadController extends Controller
{
    /**
     * DownloadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'category', 'show', 'tag']);
    }

    /**
     * 列表页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * 下载Tag页
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function tag($id)
    {

    }

    /**
     * 栏目列表页
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function category($category_id)
    {

    }

    /**
     * 查看下载详情
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {

    }

    /**
     * 下载文件
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function download(Request $request, $id)
    {

    }
}
