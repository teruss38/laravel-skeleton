<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

use App\Services\PhoneVerifyCodeService;
use Illuminate\Support\Facades\Log;

/**
 * 手机短信验证码验证
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PhoneVerifyCodeValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $phone = request($parameters[0] ?? 'verify_phone');

        if (\is_numeric($parameters[0])) {
            $phone = $parameters[0];
        }

        Log::debug('phone verify: ', [$parameters, $phone]);

        $service = PhoneVerifyCodeService::make($phone);
        if (config('app.env') == 'testing') {
            $service->setFixedVerifyCode(1234);
        }
        if ($service->validate($value, false)) {
            return true;
        }
        return false;
    }
}
