<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\V1\Integral;

use App\Http\Requests\Request;

/**
 * 金币提现
 * @property-read int $recipient_id
 * @property-read int $coin
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WithdrawalsRequest extends Request
{
    /**
     * @var int 最小提现
     */
    protected $withdrawalsMix = 0;

    /**
     * @var int 当前积分
     */
    protected $integralBalance = 0;

    /**
     * @var string
     */
    public $channel;

    /**
     * @var array 结算账户信息
     */
    public $metaData = [];

    public $account;

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
        $this->withdrawalsMix = config('services.credit.withdrawals_mix', 100);
        $this->integralBalance = $this->user()->integralBalance;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'integral' => [
                'required',
                'numeric',
                'max:' . $this->integralBalance,
                'min:' . $this->withdrawalsMix
            ],
            'recipient_id' => [
                'required',
                'numeric',
                'exists:user_settle_accounts,id',
            ],
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    public function passedValidation()
    {
        $settleAccount = $this->user()->settleAccounts()->where('id', '=', $this->recipient_id)->firstOrFail();
        $this->channel = $settleAccount->channel;
        $this->account = $settleAccount->account;
        $this->metaData = $settleAccount->recipient;
    }

    /**
     * 获取错误消息提示
     * @return array
     */
    public function messages()
    {
        return [
            'credit.required' => '提现积分必填！',
            'credit.min' => '最低提现积分' . $this->withdrawalsMix ,
            'credit.max' => '账户积分不足，请先充值！',
            'recipient_id.required' => '提现账户必须选择！',
            'recipient_id.exists' => '提现账户不存在！'
        ];
    }
}
