<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\Support;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * 点赞
 *
 * @property-read boolean $isSupported 是否已经赞过
 * @property \Illuminate\Database\Eloquent\Model $this
 * @author Tongle Xu <xutongle@gmail.com>
 */
trait HasSupport
{

    /**
     * support Relation
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function supports()
    {
        return $this->morphMany(Support::class, 'source');
    }

    /**
     * 是否赞过
     * @param \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @return bool
     */
    public function supported($user): bool
    {
        if ($user) {
            return $this->supports()->where(['user_id' => $user->getAuthIdentifier()])->exists();
        }
        return false;
    }

    /**
     * 是否赞过
     * @return bool
     */
    public function getIsSupportedAttribute()
    {
        return $this->supported(Auth::guard()->user());
    }
}
