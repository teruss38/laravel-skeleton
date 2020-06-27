<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models\Traits;

use App\Models\User;

/**
 * Trait HasCreator.
 *
 * @property \App\Models\User $creator
 */
class BelongsToCreator
{
    public static function bootHasCreator()
    {
        static::saving(function ($model) {
            $model->creator_id = $model->creator_id ?? \auth()->id() ?? User::SYSTEM_USER_ID;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    /**
     * @param \App\Models\User|int $user
     *
     * @return bool
     */
    public function isCreatedBy($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->creator_id == \intval($user);
    }
}
