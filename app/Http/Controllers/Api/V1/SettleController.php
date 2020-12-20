<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Settle\StoreSettleAccountsRequest;
use App\Http\Resources\Api\V1\Settle\SettleAccountsResource;
use App\Models\UserSettleAccount;
use Illuminate\Http\Request;

/**
 * 结算账户
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SettleController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 获取结算账户
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $settleAccounts = $request->user()->settleAccounts()->orderByDesc('id')->paginate(10);
        return SettleAccountsResource::collection($settleAccounts);
    }

    /**
     * 添加结算账户
     * @param StoreSettleAccountsRequest $request
     * @return SettleAccountsResource
     */
    public function store(StoreSettleAccountsRequest $request)
    {
        $settle = new UserSettleAccount(['channel' => $request->channel, 'user_id' => $request->user()->id]);
        $settle->setRecipient($request->except(['channel']));
        $settle->save();
        return new SettleAccountsResource($settle);
    }

    /**
     * 查看结算账户
     * @param Request $request
     * @param int $id
     * @return SettleAccountsResource
     */
    public function show(Request $request, $id)
    {
        $settle = $request->user()->settleAccounts()->where('id', '=', $id)->firstOrFail();
        return new SettleAccountsResource($settle);
    }

    /**
     * 删除结算账户
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->settleAccounts()->where('id', '=', $id)->delete();
        return $this->withNoContent();
    }
}
