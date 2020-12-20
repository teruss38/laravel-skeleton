<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\V1\Wallet;

use App\Http\Requests\Request;

/**
 * 余额充值
 * @property-read string $channel
 * @property-read string $type
 * @property-read int $amount
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class RechargeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|string',
        ];
    }
}
