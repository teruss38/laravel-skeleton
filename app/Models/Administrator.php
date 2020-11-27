<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;


/**
 * 管理员表
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $avatar
 *
 * @property User $user
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Administrator extends \Dcat\Admin\Models\Administrator
{
    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting()
    {
        static::created(function ($model) {
            $user = User::create(['username' => User::generateUsername($model->username), 'password' => $model->password]);
            $model->user_id = $user->id;
            $model->saveQuietly();
        });
        static::updated(function ($model) {
            $model->user->password = $model->password;
            $model->user->saveQuietly();
        });
    }
}
