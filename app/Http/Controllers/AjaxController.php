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
 * Class AjaxController
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AjaxController extends Controller
{
    /**
     * 前端 Ajax 获取用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $result = ['isLogin' => false];
        if (($user = $request->user()) != null) {
            $result = [
                'isLogin' => true,
                'id' => $user->id,
                'username' => $user->username,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar,
                'email' => $user->email,
                'phone' => $user->phone,
                'unreadNotificationCount' => $user->unreadNotifications()->count()
            ];
        }
        return response()->json($result);
    }
}
