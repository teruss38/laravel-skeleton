<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 用户模型
 * @property int $id ID
 * @property string $phone 手机号
 * @property string $username 昵称
 * @property string $email 邮箱
 * @property string $password 密码
 * @property string $remember_token
 * @property string $avatar_path 头像路径
 * @property boolean $disabled 是否已经停用
 * @property \Illuminate\Support\Carbon|null $phone_verified_at 手机验证时间
 * @property \Illuminate\Support\Carbon|null $email_verified_at 邮箱验证时间
 * @property \Illuminate\Support\Carbon|null $first_sign_in_at 开始签到时间
 * @property \Illuminate\Support\Carbon|null $created_at 注册时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 *
 * @property-read boolean $hasAvatar 是否有头像
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * 模型数据表
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 允许批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'phone', 'password', 'avatar_path', 'disabled', 'first_sign_in_at'
    ];

    /**
     * 隐藏输出的属性
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 属性类型转换
     *
     * @var array
     */
    protected $casts = [
        'disabled' => 'boolean',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'first_sign_in_at' => 'datetime',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'disabled' => false,
    ];

    /**
     * 为数组 / JSON 序列化准备日期。
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: config('system.date_format'));
    }

    /**
     * 查询未禁用的
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('disabled', '=', false);
    }

    /**
     * 是否有头像
     * @return boolean
     */
    public function getHasAvatarAttribute()
    {
        return !empty($this->avatar_path);
    }

    /**
     * 获取手机号
     * @param \Illuminate\Notifications\Notification|null $notification
     * @return int|null
     */
    public function routeNotificationForPhone($notification)
    {
        return $this->phone;
    }

    /**
     * 用户是否在线
     * @return bool
     */
    public function isOnline()
    {
        return \Illuminate\Support\Facades\Cache::has('user-online-' . $this->primaryKey);
    }

    /**
     * 发送邮箱验证通知
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        if (!is_null($this->email)) {
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        }
    }

    /**
     * Determine if the user has verified their phone number.
     *
     * @return bool
     */
    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Mark the given user's phone as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        $status = $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
        event(new \App\Events\User\PhoneVerified($this));
        return $status;
    }

    /**
     * Mark the given user's disabled.
     *
     * @return bool
     */
    public function markDisabled()
    {
        return $this->forceFill([
            'disabled' => true,
        ])->save();
    }

    /**
     * Determine if the user has disabled.
     *
     * @return bool
     */
    public function hasDisabled()
    {
        return $this->disabled;
    }

    /**
     * 重置用户密码
     *
     * @param string $password
     * @return void
     */
    public function resetPassword($password)
    {
        $this->password = \Illuminate\Support\Facades\Hash::make($password);
        $this->setRememberToken(\Illuminate\Support\Str::random(60));
        $this->save();
        event(new \Illuminate\Auth\Events\PasswordReset($this));
    }

    /**
     * 重置用户手机号
     * @param int $phone
     * @return bool
     */
    public function resetPhone($phone)
    {
        $status = $this->forceFill([
            'phone' => $phone,
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
        event(new \App\Events\User\PhoneReset($this));
        return $status;
    }

    /**
     * 重置用户邮箱
     * @param string $email
     * @return bool
     */
    public function resetEmail($email)
    {
        $status = $this->forceFill([
            'email' => $email,
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
        event(new \App\Events\User\MailReset($this));
        return $status;
    }

    /**
     * 查找用户
     * @param string $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        if (preg_match(config('system.phone_rule'), $username)) {
            return static::active()
                ->where('phone', $username)
                ->first();
        } else if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return static::active()
                ->where('email', $username)
                ->first();
        } else {
            return static::active()
                ->where('username', $username)
                ->first();
        }
    }

    /**
     * 随机生成一个用户名
     * @param string $username 用户名
     * @return string
     */
    public static function generateUsername($username)
    {
        if (static::query()->where('username', '=', $username)->exists()) {
            $row = static::query()->max('id');
            $username = $username . ++$row;
        }
        return $username;
    }
}
