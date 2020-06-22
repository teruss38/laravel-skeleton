<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

use App\Services\MailVerifyCodeService;

/**
 * Class MailVerifyValidator
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MailVerifyValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $verifyCode = MailVerifyCodeService::make($value);
        if ($verifyCode->getIpSendCount() > 20) {//一个IP地址每天最多发送 20 封
            return false;
        }
        if ($verifyCode->getMailSendCount() > 10) {//一个邮箱每天最多发送 10 封
            return false;
        }
        return true;
    }
}
