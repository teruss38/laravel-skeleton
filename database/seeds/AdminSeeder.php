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

class AdminSeeder extends Seeder
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

        //认证管理
        $this->addPermission([
            'name' => '认证管理',
            'slug' => 'auth-management',
            'http_method' => '',
            'http_path' => '',
            'parent_id' => 0,
            'order' => 1,
        ], [
            [
                'name' => '管理员管理',
                'slug' => 'users',
                'http_method' => '',
                'http_path' => '/auth/users*',
            ],
            [
                'name' => '角色管理',
                'slug' => 'roles',
                'http_method' => '',
                'http_path' => '/auth/roles*',
            ],
            [
                'name' => '权限管理',
                'slug' => 'permissions',
                'http_method' => '',
                'http_path' => '/auth/permissions*',
            ],
            [
                'name' => '菜单管理',
                'slug' => 'menu',
                'http_method' => '',
                'http_path' => '/auth/menu*',
            ],
            [
                'name' => '操作日志',
                'slug' => 'operation-log',
                'http_method' => '',
                'http_path' => '/auth/logs*',
            ],
            [
                'name' => '网站设置',
                'slug' => 'settings-system',
                'http_method' => '',
                'http_path' => '/settings',
            ],
        ]);
        //数据管理
        $this->addPermission([
            'name' => '数据管理',
            'slug' => 'dictionary-management',
            'http_method' => '',
            'http_path' => '',
            'parent_id' => 0,
            'order' => 2,
        ], [
            [
                'name' => '敏感词管理',
                'slug' => 'stop-word-management',
                'http_method' => '',
                'http_path' => '/dictionary/stop-words*',
            ],
            [
                'name' => '关键词管理',
                'slug' => 'key-word-management',
                'http_method' => '',
                'http_path' => '/dictionary/key-words*',
            ],
            [
                'name' => '地区管理',
                'slug' => 'region-management',
                'http_method' => '',
                'http_path' => '/dictionary/region*',
            ],
            [
                'name' => 'Tag管理',
                'slug' => 'content-tags',
                'http_method' => '',
                'http_path' => 'content/tags*',
            ],
            [
                'name' => '文章栏目管理',
                'slug' => 'content-article-categories-management',
                'http_method' => '',
                'http_path' => '/content/categories*',
            ],
        ]);

        //用户管理
        $this->addPermission([
            'name' => '用户管理',
            'slug' => 'user-management',
            'http_method' => '',
            'http_path' => '',
            'parent_id' => 0,
            'order' => 3,
        ], [
            [
                'name' => 'OAuth客户端管理',
                'slug' => 'oauth-management',
                'http_method' => '',
                'http_path' => '/user/clients*',
            ],
            [
                'name' => '用户管理管理',
                'slug' => 'user-members',
                'http_method' => '',
                'http_path' => '/user/members*',
            ],
            [
                'name' => '社交账户管理',
                'slug' => 'user-socials',
                'http_method' => '',
                'http_path' => '/user/socials*',
            ]
        ]);

        //内容管理
        $this->addPermission([
            'name' => '内容管理',
            'slug' => 'content-management',
            'http_method' => '',
            'http_path' => '',
            'parent_id' => 0,
            'order' => 4,
        ], [
            [
                'name' => '文章管理',
                'slug' => 'content-articles-management',
                'http_method' => '',
                'http_path' => '/content/articles*',
            ],

        ]);
        //模块管理
        $this->addPermission([
            'name' => '模块管理',
            'slug' => 'module-management',
            'http_method' => '',
            'http_path' => '',
            'parent_id' => 0,
            'order' => 5,
        ], [
            [
                'name' => '友情链接管理',
                'slug' => 'module-links-management',
                'http_method' => '',
                'http_path' => 'module/links',
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

        //系统设置 2
        $this->addSubMenu(2, [
            [
                'title' => '网站设置',
                'icon' => '',
                'uri' => 'settings',
            ],
            [
                'title' => '管理员管理',
                'icon' => '',
                'uri' => 'auth/users',
            ],
            [
                'title' => '角色管理',
                'icon' => '',
                'uri' => 'auth/roles',
            ],
            [
                'title' => '权限管理',
                'icon' => '',
                'uri' => 'auth/permissions',
            ],
            [
                'title' => '菜单管理',
                'icon' => '',
                'uri' => 'auth/menu',
            ],
            [
                'title' => '操作日志',
                'icon' => '',
                'uri' => 'auth/logs',
            ],
        ]);
        //数据管理 3
        $this->addSubMenu(3, [
            [
                'title' => '敏感词管理',
                'icon' => '',
                'uri' => 'dictionary/stop-words',
            ],
            [
                'title' => '关键词管理',
                'icon' => '',
                'uri' => 'dictionary/key-words',
            ],
            [
                'title' => '地区管理',
                'icon' => '',
                'uri' => 'dictionary/region',
            ],
            [
                'title' => 'Tag管理',
                'icon' => '',
                'uri' => 'content/tags',
            ],
            [
                'title' => '文章栏目管理',
                'icon' => '',
                'uri' => 'content/categories',
            ],
        ]);
        //内容管理 4
        $this->addSubMenu(4, [
            [
                'title' => '文章管理',
                'icon' => '',
                'uri' => 'content/articles',
            ],
        ]);
        //会员管理 5
        $this->addSubMenu(5, [
            [
                'title' => 'Auth客户端',
                'icon' => '',
                'uri' => 'user/clients',
            ],
            [
                'title' => '会员管理',
                'icon' => '',
                'uri' => 'user/members',
            ],
            [
                'title' => '社交用户管理',
                'icon' => '',
                'uri' => 'user/socials',
            ],
        ]);

        //模块管理 6
        $this->addSubMenu(6, [
            [
                'title' => '友情链接管理',
                'icon' => '',
                'uri' => 'module/links',
            ],
        ]);

        (new Menu())->flushCache();
    }

    /**
     * 添加权限
     * @param array $parenPermission 父权限
     * @param array $permissions 子权限
     */
    public function addPermission($parenPermission = [], $permissions = []): void
    {
        $createdAt = date('Y-m-d H:i:s');
        $parenPermission['created_at'] = $createdAt;
        $permissionId = Permission::insertGetId($parenPermission);
        $i = 1;
        foreach ($permissions as $permission) {
            $permission['parent_id'] = $permissionId;
            $permission['order'] = $i;
            $permission['created_at'] = $createdAt;
            Permission::insert($permission);
            $i++;
        }
    }

    /**
     * 添加子菜单
     * @param int $parentId 父菜单ID
     * @param array $menus 子菜单
     */
    public function addSubMenu($parentId, $menus = []): void
    {
        $createdAt = date('Y-m-d H:i:s');
        $i = 1;
        foreach ($menus as $menu) {
            $menu['parent_id'] = $parentId;
            $menu['order'] = $i;
            $menu['created_at'] = $createdAt;
            Menu::insert($menu);
            $i++;
        }
    }

    /**
     * 添加菜单
     * @param array $parentMenu 父菜单
     * @param array $menus 子菜单
     */
    public function addMenu($parentMenu = [], $menus = []): void
    {
        $createdAt = date('Y-m-d H:i:s');
        $parentMenu['created_at'] = $createdAt;
        $menuId = Menu::insertGetId($parentMenu);
        $i = 1;
        foreach ($menus as $menu) {
            $menu['parent_id'] = $menuId;
            $menu['order'] = $i;
            $menu['created_at'] = $createdAt;
            Menu::insert($menu);
            $i++;
        }
    }
}
