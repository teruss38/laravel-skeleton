<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 社交账户
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $nickname
 * @property string $email
 * @property string $avatar
 * @property string $provider
 * @property string $union_id
 * @property string $social_id
 * @property string $access_token
 * @property array $data
 * @property string $token_expires_at
 * @property string $refresh_token
 * @property User $user
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read string $openid
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial bySocialAndProvider($id, $provider)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSocial byUnionIdAndProvider($id, $provider)
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserSocial extends Model
{
    const SERVICE_WECHAT = 'wechat';
    const SERVICE_WECHAT_WEB = 'wechat_web';
    const SERVICE_WECHAT_MOBILE = 'wechat_mobile';
    const SERVICE_WECHAT_MINI_PROGRAM = 'wechat_mini_program';
    const SERVICE_BAIDU_SMART_PROGRAM = 'baidu_smart_program';
    const SERVICE_WEIBO = 'weibo';
    const SERVICE_QQ = 'qq';
    const SERVICE_ALIPAY = 'alipay';
    const SERVICE_BAIDU = 'baidu';


    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'user_social_accounts';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'nickname', 'email', 'avatar', 'provider', 'union_id', 'social_id', 'access_token',
        'data',
    ];

    /**
     * 这个属性应该被转换为原生类型.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 链接用户
     * @param User $user
     * @return bool
     */
    public function connect(User $user)
    {
        return $this->update(['user_id' => $user->id]);
    }

    /**
     * 解除绑定
     * @return bool
     */
    public function unbind()
    {
        return $this->update(['user_id' => null]);
    }
    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySocialAndProvider($query, $id, $provider)
    {
        return $query->where('social_id', $id)->where('provider', $provider);
    }

    /**
     * 查询指定的提供商
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $id
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUnionIdAndProvider($query, $id, $provider)
    {
        return $query->where('union_id', $id)->where('provider', $provider);
    }
}
