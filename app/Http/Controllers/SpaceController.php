<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers;

use App\Models\User;
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
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(User $user)
    {
        \App\Models\UserExtra::inc($user->id, 'views');
        $items = $user->supports()->with('source')->paginate();
        return view('space.index', ['user' => $user, 'items' => $items]);
    }

    /**
     * TA的文章
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function articles(User $user)
    {
        $items = $user->articles()->with('source')->paginate();
        return view('space.article', ['user' => $user, 'items' => $items]);
    }

    /**
     * TA的资源
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function downloads(User $user)
    {
        $items = $user->downloads()->paginate();
        return view('space.download', ['user' => $user, 'items' => $items]);
    }

    /**
     * TA的收藏
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function collections(User $user, Request $request)
    {
        $type = $request->get('type', 'article');
        $items = $user->collections()->type($type)->with('source')->paginate();
        return view('space.collection', ['user' => $user, 'type' => $type, 'items' => $items]);
    }

    /**
     * TA的关注
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function attentions(User $user, Request $request)
    {
        $type = $request->get('type', 'user');
        $items = $user->attentions()->type($type)->with('source')->paginate();
        return view('space.attention', ['user' => $user, 'type' => $type, 'items' => $items]);
    }

    /**
     * TA的粉丝
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function followers(User $user)
    {
        $items = $user->followers()->with('user')->paginate();
        return view('space.follower', ['user' => $user, 'items' => $items]);
    }
}
