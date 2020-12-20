<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\Integral;

use App\Http\Resources\Resource;
use Larva\Integral\Models\Transaction;

/**
 * 交易明细
 *
 * @mixin Transaction
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TransactionResource extends Resource
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
            'integral' => $this->integral,
            'current_integral' => $this->current_integral,
            'description' => $this->description,
            'type' => $this->type,
            'typeName' => $this->typeName,
            'client_ip' => $this->client_ip,
            'created_at' => $this->created_at->toDateTimeString(),
            'source' => $this->source,
        ];
    }
}
