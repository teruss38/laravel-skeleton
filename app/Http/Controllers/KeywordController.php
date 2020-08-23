<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * 搜索热词
 * @author Tongle Xu <xutongle@gmail.com>
 */
class KeywordController extends Controller
{
    /**
     * The response factory implementation.
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * RankingController constructor.
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->response = $response;
    }

    /**
     * 热词首页
     * @param string $type 热词类型
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Keyword::query()->orderByDesc('id')->paginate();
        return $this->response->view('keyword.index', [
            'items' => $items
        ]);
    }

    /**
     * 热词详情
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $item = Keyword::query()->findOrFail($id);
        /*热度+1*/
        $item->increment('frequency');
        $items = Keyword::latest(10);
        return $this->response->view('keyword.show', [
            'items' => $items,
            'item' => $item
        ]);
    }
}
