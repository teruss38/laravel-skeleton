<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Larva\Censor\Models\StopWord;

/**
 * Class StopWordSeeder
 * @author Tongle Xu <xutongle@gmail.com>
 */
class StopWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StopWord::insert([
            [
                'ugc' => '{MOD}',
                'find' => '测试'
            ],
            [
                'ugc' => '{BANNED}',
                'find' => '代孕'
            ],
        ]);
    }
}
