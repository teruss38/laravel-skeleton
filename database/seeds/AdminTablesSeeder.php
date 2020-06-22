<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.arva.com.cn/
 * @license http://www.arva.com.cn/license/
 */

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Menu;
use Dcat\Admin\Models\Permission;
use Dcat\Admin\Models\Role;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = date('Y-m-d H:i:s');

        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name' => 'Administrator',
            'created_at' => $createdAt,
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name' => 'Administrator',
            'slug' => Role::ADMINISTRATOR,
            'created_at' => $createdAt,
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission
        Permission::truncate();
        Permission::insert([
            [
                'id' => 1,
                'name' => '认证管理',
                'slug' => 'auth-management',
                'http_method' => '',
                'http_path' => '',
                'parent_id' => 0,
                'order' => 1,
                'created_at' => $createdAt,
            ],
            [
                'id' => 2,
                'name' => '管理员管理',
                'slug' => 'users',
                'http_method' => '',
                'http_path' => '/auth/users*',
                'parent_id' => 1,
                'order' => 2,
                'created_at' => $createdAt,
            ],
            [
                'id' => 3,
                'name' => '角色管理',
                'slug' => 'roles',
                'http_method' => '',
                'http_path' => '/auth/roles*',
                'parent_id' => 1,
                'order' => 3,
                'created_at' => $createdAt,
            ],
            [
                'id' => 4,
                'name' => '权限管理',
                'slug' => 'permissions',
                'http_method' => '',
                'http_path' => '/auth/permissions*',
                'parent_id' => 1,
                'order' => 4,
                'created_at' => $createdAt,
            ],
            [
                'id' => 5,
                'name' => '菜单管理',
                'slug' => 'menu',
                'http_method' => '',
                'http_path' => '/auth/menu*',
                'parent_id' => 1,
                'order' => 5,
                'created_at' => $createdAt,
            ],
            [
                'id' => 6,
                'name' => '操作日志',
                'slug' => 'operation-log',
                'http_method' => '',
                'http_path' => '/auth/logs*',
                'parent_id' => 1,
                'order' => 6,
                'created_at' => $createdAt,
            ],
            [
                'id' => 7,
                'name' => '网站设置',
                'slug' => 'settings-system',
                'http_method' => '',
                'http_path' => '/settings/system',
                'parent_id' => 1,
                'order' => 7,
                'created_at' => $createdAt,
            ],
            [
                'id' => 8,
                'name' => '附件设置',
                'slug' => 'settings-storage',
                'http_method' => '',
                'http_path' => '/settings/storage',
                'parent_id' => 1,
                'order' => 8,
                'created_at' => $createdAt,
            ],
        ]);


        Permission::insert([
            [
                'id' => 9,
                'name' => '用户管理',
                'slug' => 'user-management',
                'http_method' => '',
                'http_path' => '',
                'parent_id' => 0,
                'order' => 1,
                'created_at' => $createdAt,
            ],

            [
                'id' => 10,
                'name' => '用户设置',
                'slug' => 'settings-user',
                'http_method' => '',
                'http_path' => '/user/settings/basic',
                'parent_id' => 9,
                'order' => 2,
                'created_at' => $createdAt,
            ],
            [
                'id' => 11,
                'name' => 'OAuth客户端管理',
                'slug' => 'oauth-management',
                'http_method' => '',
                'http_path' => 'user/clients',
                'parent_id' => 9,
                'order' => 3,
                'created_at' => $createdAt,
            ],
        ]);

//        Role::first()->permissions()->save(Permission::first());

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order' => 1,
                'title' => '控制台',
                'icon' => 'feather icon-bar-chart-2',
                'uri' => '/',
                'created_at' => $createdAt,
            ],//仪表盘 1
            [
                'parent_id' => 0,
                'order' => 2,
                'title' => '系统设置',
                'icon' => 'feather icon-settings',
                'uri' => '',
                'created_at' => $createdAt,
            ],//认证管理 2
            [
                'parent_id' => 0,
                'order' => 4,
                'title' => '数据管理',
                'icon' => 'fa-archive',
                'uri' => '',
                'created_at' => $createdAt,
            ],//数据管理 3
            [
                'parent_id' => 0,
                'order' => 5,
                'title' => '内容管理',
                'icon' => 'fa-archive',
                'uri' => '',
                'created_at' => $createdAt,
            ],//内容管理 4
            [
                'parent_id' => 0,
                'order' => 6,
                'title' => '会员管理',
                'icon' => 'feather icon-users',
                'uri' => '',
                'created_at' => $createdAt,
            ],//会员管理 5
            [
                'parent_id' => 0,
                'order' => 7,
                'title' => '模块管理',
                'icon' => 'fa-modx',
                'uri' => '',
                'created_at' => $createdAt,
            ],//模块管理 6
        ]);

        Menu::insert([
            //系统设置 2
            [
                'parent_id' => 2,
                'order' => 1,
                'title' => '网站设置',
                'icon' => '',
                'uri' => 'settings/system',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 2,
                'order' => 2,
                'title' => '管理员管理',
                'icon' => '',
                'uri' => 'auth/users',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 2,
                'order' => 3,
                'title' => '角色管理',
                'icon' => '',
                'uri' => 'auth/roles',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 2,
                'order' => 4,
                'title' => '权限管理',
                'icon' => '',
                'uri' => 'auth/permissions',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 2,
                'order' => 5,
                'title' => '菜单管理',
                'icon' => '',
                'uri' => 'auth/menu',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 2,
                'order' => 6,
                'title' => '操作日志',
                'icon' => '',
                'uri' => 'auth/logs',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 2,
                'order' => 7,
                'title' => '附件设置',
                'icon' => '',
                'uri' => 'settings/storage',
                'created_at' => $createdAt,
            ],

            //数据管理 3
            [
                'parent_id' => 3,
                'order' => 1,
                'title' => '敏感词管理',
                'icon' => '',
                'uri' => 'dictionary/system',
                'created_at' => $createdAt,
            ],

            //内容管理 4

            //会员管理 5
            [
                'parent_id' => 5,
                'order' => 1,
                'title' => '用户设置',
                'icon' => '',
                'uri' => 'user/settings/basic',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 5,
                'order' => 2,
                'title' => 'Auth客户端',
                'icon' => '',
                'uri' => 'user/clients',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 5,
                'order' => 3,
                'title' => '会员管理',
                'icon' => '',
                'uri' => 'user/members',
                'created_at' => $createdAt,
            ],
            [
                'parent_id' => 5,
                'order' => 4,
                'title' => '社交用户管理',
                'icon' => '',
                'uri' => 'user/socials',
                'created_at' => $createdAt,
            ],

            //模块管理 6

        ]);

        (new Menu())->flushCache();
    }
}
