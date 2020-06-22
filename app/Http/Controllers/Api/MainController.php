<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Class MainController
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except([
            'mailVerifyCode',
        ]);
        //$this->middleware('throttle:1,2')->only('phoneVerifyCode', 'mailVerifyCode');
    }

    /**
     * Mail验证码
     * @param \App\Http\Requests\Api\Main\MailVerifyCodeRequest $request
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function mailVerifyCode(\App\Http\Requests\Api\Main\MailVerifyCodeRequest $request)
    {
        $verifyCode = \App\Services\MailVerifyCodeService::make($request->email);
        $verifyCode->setIp($request->getClientIp());//记录客户端IP
        return $verifyCode->send();
    }


}
