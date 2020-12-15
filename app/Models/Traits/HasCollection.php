<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\User;
use App\Models\UserCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * 收藏
 *
 * @property-read boolean $isCollected
 * @property \Illuminate\Database\Eloquent\Model $this
 * @author Tongle Xu <xutongle@gmail.com>
 */
trait HasCollection
{
    /**
     * Collection Relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function collections()
    {
        return $this->morphMany(UserCollection::class, 'source');
    }

    /**
     * 获取指定的指定收藏
     * @param \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @return UserCollection|Model|\Illuminate\Database\Eloquent\Relations\MorphMany|object
     */
    public function getCollection($user)
    {
        return $this->collections()->where(['user_id' => $user->getAuthIdentifier()])->first();
    }

    /**
     * 是否收藏过
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @return bool
     */
    public function isCollected($user)
    {
        if ($user) {
            return $this->collections()->where(['user_id' => $user->getAuthIdentifier()])->exists();
        }
        return false;
    }

    /**
     * 是否收藏过
     * @return bool
     */
    public function getIsCollectedAttribute()
    {
        return $this->isCollected(Auth::guard()->user());
    }
}
