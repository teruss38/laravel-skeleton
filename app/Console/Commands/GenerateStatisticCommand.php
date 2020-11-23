<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Console\Commands;

use App\Models\Statistic;
use Illuminate\Console\Command;

/**
 * 生成每日统计
 * @author Tongle Xu <xutongle@gmail.com>
 */
class GenerateStatisticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Statistic Daily';

    /**
     * @var \Carbon\CarbonInterface
     */
    protected $yesterday = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->yesterday = \Illuminate\Support\Carbon::yesterday(config('app.timezone'));
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']开始执行统计脚本');
        try {
            $this->user();
            $this->device();
            $this->info('[' . date('Y-m-d H:i:s', time()) . ']统计完成!');
        } catch (\Exception $exception) {
            $this->error('执行统计失败：' . $exception->getMessage());
        }
    }

    /**
     * 统计昨天新注册用户数
     */
    public function user()
    {
        if (!Statistic::query()->where('type', Statistic::TYPE_NEW_USER)->whereDate('date', $this->yesterday)->exists()) {
            $quantity = \App\Models\User::query()->whereDate('created_at', $this->yesterday)->count();
            Statistic::create(['type' => Statistic::TYPE_NEW_USER, 'date' => $this->yesterday->toDateString(), 'quantity' => $quantity]);
        }
    }

    /**
     * 统计昨天新注册设备数
     */
    public function device()
    {
        if (!Statistic::query()->where('type', Statistic::TYPE_NEW_DEVICE_ANDROID)->whereDate('date', $this->yesterday)->exists()) {
            $quantity = \App\Models\UserDevice::query()->whereDate('created_at', $this->yesterday)->count();
            Statistic::create(['type' => Statistic::TYPE_NEW_DEVICE_ANDROID, 'date' => $this->yesterday->toDateString(), 'quantity' => $quantity]);
        }
        if (!Statistic::query()->where('type', Statistic::TYPE_NEW_DEVICE_IOS)->whereDate('date', $this->yesterday)->exists()) {
            $quantity = \App\Models\UserDevice::query()->whereDate('created_at', $this->yesterday)->count();
            Statistic::create(['type' => Statistic::TYPE_NEW_DEVICE_IOS, 'date' => $this->yesterday->toDateString(), 'quantity' => $quantity]);
        }
    }
}
