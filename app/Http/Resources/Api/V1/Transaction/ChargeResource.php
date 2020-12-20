<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\Transaction;

use App\Http\Resources\Resource;
use Larva\Transaction\Models\Charge;

/**
 * Class Charge
 * @mixin Charge
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ChargeResource extends Resource
{
    /**
     * 禁用资源包裹
     *
     * @var string
     */
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'paid' => $this->paid,
            'refunded' => $this->refunded,
            'reversed' => $this->reversed,
            'channel' => $this->channel,
            'type' => $this->type,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'subject' => $this->subject,
            'body' => $this->body,
            'client_ip' => $this->client_ip,
            'extra' => $this->extra,
            'time_paid' => $this->time_paid,
            'transaction_no' => $this->transaction_no,
            'time_expire' => $this->time_expire,
            'amount_refunded' => $this->amount_refunded,
            'failure_code' => $this->failure_code,
            'failure_msg' => $this->failure_msg,
            'description' => $this->description,
            'credential' => $this->credential,
        ];
    }
}
