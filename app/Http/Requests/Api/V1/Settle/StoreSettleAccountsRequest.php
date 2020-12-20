<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\V1\Settle;

use App\Http\Requests\Request;
use App\Models\UserIdentification;

/**
 * 添加结算账户
 * @property-read string $channel 提现账户类型
 * @property-read string $name 账户开户名
 * @property-read string $account 账户
 * @property-read string $type 账户类型
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class StoreSettleAccountsRequest extends Request
{
    /**
     * @var boolean
     */
    public $identified;

    /**
     * @var UserIdentification
     */
    public $identification;

    /**
     * @var string
     */
    public $realName;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)$this->user();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        //$this->identified = $this->user()->identified;
       // $this->realName = $this->user()->identification->realName;
    }

    /**
     * 配置验证器实例。
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
//        $validator->after(function ($validator) {
//            if (config('app.env') != 'testing') {
////                if (!$this->identified) {
////                    $validator->errors()->add('name', '你需要先实名认证才能创建结算账户!');
////                }
////                if ($this->realName != $this->name) {
////                    $validator->errors()->add('name', '账户开户名必须和实名认证的姓名一致！');
////                }
//            }
//        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'account' => 'required|string|max:191',
            'type' => 'required|in:b2c,b2b',
        ];
    }

    /**
     * 获取错误消息提示
     * @return array
     */
    public function messages()
    {
        return [
            'type.in' => '账户类型不合法！',
        ];
    }
}
