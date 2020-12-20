<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Resources\Api\V1\Settle;

use App\Http\Resources\Resource;
use App\Models\UserSettleAccount;

/**
 * 用户结算账户响应
 * @mixin UserSettleAccount
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SettleAccountsResource extends Resource
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
            'channel' => $this->channel,
            'account' => $this->account,
            'name' => $this->name,
            'type' => $this->type,
            'recipient'=>$this->recipient,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

