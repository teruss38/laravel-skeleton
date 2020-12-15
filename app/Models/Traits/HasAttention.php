<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\Attention;
use App\Models\User;
use App\Models\UserCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * 关注
 * @property-read boolean $isFollowed
 * @property \Illuminate\Database\Eloquent\Model $this
 * @author Tongle Xu <xutongle@gmail.com>
 */
trait HasAttention
{
    /**
     * 获取粉丝
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function followers()
    {
        return $this->morphToMany(Attention::class, 'source','attentions','source_id','id');
    }

    /**
     * 我的关注
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attentions()
    {
        return $this->morphMany(Attention::class, 'source');
    }

    /**
     * 获取关注
     * @param \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @return UserCollection|Model|\Illuminate\Database\Eloquent\Relations\MorphMany|object
     */
    public function getAttention($user)
    {
        return $this->attentions()->where('user_id', $user->getAuthIdentifier())->first();
    }

    /**
     * 是否已经关注
     * @param \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @return bool
     */
    public function followed($user)
    {
        if ($user) {
            return $this->attentions()->where(['user_id' => $user->getAuthIdentifier()])->exists();
        }
        return false;
    }

    /**
     * 是否已经关注
     * @return bool
     */
    public function getIsFollowedAttribute()
    {
        return $this->followed(Auth::guard()->user());
    }
}
