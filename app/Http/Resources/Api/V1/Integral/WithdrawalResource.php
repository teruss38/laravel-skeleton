<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\Integral;

use App\Http\Resources\Resource;
use Larva\Integral\Models\Withdrawal;

/**
 * Class WithdrawalResource
 * @mixin Withdrawal
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WithdrawalResource extends Resource
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
            'user' => $this->user,
            'coin' => $this->coin,
            'status' => $this->status,
            'channel' => $this->channel,
            'recipient' => $this->recipient,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at->toDateTimeString(),
            'canceled_at' => $this->canceled_at ? $this->canceled_at->toDateTimeString() : null,
            'succeeded_at' => $this->succeeded_at ? $this->succeeded_at->toDateTimeString() : null,
        ];
    }
}

