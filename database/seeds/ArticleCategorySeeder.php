<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;

/**
 * Class CategorySeeder
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleCategory::insert([
            [
                'title' => '新闻头条',
                'description' => '新闻头条'
            ],
        ]);
    }
}
