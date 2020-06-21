<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

/**
 * 是否是手机号码或固话
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PhoneTwoValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        if (!preg_match(config('system.phone_two_rule'), $value)) {
            return false;
        }
        return true;
    }
}
