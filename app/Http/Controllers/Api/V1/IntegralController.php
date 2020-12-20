<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Integral\WithdrawalsRequest;
use App\Http\Requests\Api\V1\Integral\RechargeRequest;
use App\Http\Resources\Api\V1\Integral\TransactionResource;
use App\Http\Resources\Api\V1\Integral\WithdrawalResource;
use App\Http\Resources\Api\V1\Transaction\ChargeResource;
use Illuminate\Http\Request;
use Larva\Integral\Models\Transaction;

/**
 * 积分
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class IntegralController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 交易明细
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function transaction(Request $request)
    {
        $transaction = Transaction::with(['user', 'source'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->paginate();
        return TransactionResource::collection($transaction);
    }

    /**
     * 积分充值
     * @param RechargeRequest $request
     * @return ChargeResource
     */
    public function recharge(RechargeRequest $request)
    {
        $recharge = $request->user()->integral->recharge($request->channel, $request->amount, $request->type, $request->getClientIp());
        return new ChargeResource($recharge->charge);
    }

    /**
     * 积分提现
     * @param WithdrawalsRequest $request
     * @return WithdrawalResource
     */
    public function withdrawals(WithdrawalsRequest $request)
    {
        $withdrawal = $request->user()->integral->withdrawal($request->integral, $request->channel, $request->account, $request->metaData);
        return new WithdrawalResource($withdrawal);
    }
}
