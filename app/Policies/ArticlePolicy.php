<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * 文章授权策略
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticlePolicy extends Policy
{
    /**
     * 确定给定用户是否可以创建文章。
     *
     * @param User $user
     * @return bool|Response
     */
    public function create(User $user)
    {
        if (!$user->hasVerifiedMobile()) {
            return Response::deny('您的邮箱还未验证，验证后才能进行该操作！');
        } else if (!$user->hasVerifiedEmail()) {
            return Response::deny('您的手机还未验证，验证后才能进行该操作！');
        }
        return true;
    }

    /**
     * 确定用户是否可以更新给定的文章。
     *
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * 确定用户是否可以查看指定的文章
     * @param User|null $user
     * @param Article $article
     * @return bool|Response
     */
    public function show(?User $user, Article $article)
    {
        if (!$article->isApproved) {
            if (!$user) {
                return Response::deny('该文章待审核！');
            } else if ($user && $user->id != $article->user_id) {
                return Response::deny('该文章待审核！');
            }
        }
        return true;
    }

    /**
     * 是否可删除
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function destroy(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
}
