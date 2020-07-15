<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

use App\Models\Tag;
use Illuminate\Database\Seeder;

/**
 * 默认标签填充
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TagSeeder extends Seeder
{
    /**
     * @var array 关键词组
     */
    protected $tags = [
        '拉瓦科技', 'Laravel', 'Larva',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tags as $tag) {
            Tag::create(['name' => $tag,]);
        }
    }
}
