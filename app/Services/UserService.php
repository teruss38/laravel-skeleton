<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * 用户服务助手
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UserService
{


    /**
     * 通过手机创建用户
     * @param int $phone
     * @param string $password
     * @return User
     */
    public static function createByPhone($phone, $password)
    {
        /** @var User $user */
        $user = User::create([
            'username' => 'm' . $phone,
            'phone' => $phone,
            'password' => Hash::make($password)
        ]);
        $user->markPhoneAsVerified();
        return $user;
    }

    /**
     * 通过邮箱创建用户
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function createByEmail($email, $password)
    {
        $emailArr = explode('@', $email);
        return static::createByUsernameAndEmail($emailArr[0], $email, $password);
    }

    /**
     * 通过用户名和邮箱创建用户
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function createByUsernameAndEmail($username, $email, $password)
    {
        return User::create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
