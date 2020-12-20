<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Wallet\RechargeRequest;
use App\Http\Requests\Api\V1\Wallet\WithdrawalsRequest;
use App\Http\Resources\Api\V1\Wallet\TransactionResource;
use App\Http\Resources\Api\V1\Wallet\WithdrawalResource;
use App\Http\Resources\Api\V1\Transaction\ChargeResource;
use Illuminate\Http\Request;
use Larva\Wallet\Models\Transaction;

/**
 * 钱包
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class WalletController extends Controller
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
     * 余额充值
     * @param RechargeRequest $request
     * @return ChargeResource
     */
    public function recharge(RechargeRequest $request)
    {
        $recharge = $request->user()->balanceWallet->recharge($request->channel, $request->amount, $request->type, $request->getClientIp());
        return new ChargeResource($recharge->charge);
    }

    /**
     * 余额提现
     * @param WithdrawalsRequest $request
     * @return WithdrawalResource
     * @throws \Larva\Wallet\Exceptions\WalletException
     */
    public function withdrawals(WithdrawalsRequest $request)
    {
        $withdrawal = $request->user()->balanceWallet->withdrawal($request->amount, $request->channel, $request->account, $request->metaData, $request->getClientIp());
        return new WithdrawalResource($withdrawal);
    }
}
