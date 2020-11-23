<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

use App\Services\PhoneVerifyCodeService;

/**
 * Class PhoneVerifyValidator
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PhoneVerifyValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $verifyCode = PhoneVerifyCodeService::make($value);
        if ($verifyCode->getIpSendCount() > 20) {//一个IP地址每天最多发送 20
            return false;
        }
        if ($verifyCode->getMobileSendCount() > 10) {//一个手机号码每天最多发送 10条
            return false;
        }
        return true;
    }
}
