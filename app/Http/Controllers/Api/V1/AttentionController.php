<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Attention\FollowRequest;
use App\Models\Attention;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 关注某个支持关注的 模型变更 可以关注用户，标签，帖子
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AttentionController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * 关注请求
     * @param FollowRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function __invoke(FollowRequest $request)
    {
        $source = Attention::getSourceModel($request->type, $request->id);
        if (!$source) {
            throw new NotFoundHttpException(404);
        }
        //看我有没有关注目标
        if (($attention = $source->getFollow($request->user())) != null) {
            $attention->delete();
            return response()->json(['status' => 'unfollowed']);
        }
        $source->followers()->create(['user_id' => $request->user_id]);
        return response()->json(['status' => 'followed']);
    }
}
