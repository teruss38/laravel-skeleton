<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Middleware;

/**
 * Class LocoyAuthenticate
 * @author Tongle Xu <xutongle@gmail.com>
 */
class LocoyAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->get('token') != settings('system.locoy')) {
            abort(403);
        }
        return $next($request);
    }
}
