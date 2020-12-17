<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Console\Commands;

use App\Models\Finance;
use Illuminate\Console\Command;

/**
 * 财务统计
 * @author Tongle Xu <xutongle@gmail.com>
 */
class FinanceStatisticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finance:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Finance Statistic Daily';

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
            if (!Finance::query()->whereDate('created_at', $this->yesterday)->exists()) {
                $finance = new Finance();
                //统计钱包收入
                $finance->wallet_income = \Larva\Wallet\Models\Recharge::query()->where('status', \Larva\Wallet\Models\Recharge::STATUS_SUCCEEDED)->whereDate('created_at', $this->yesterday)->sum('amount');
                //统计钱包提现
                $finance->wallet_withdrawal = \Larva\Wallet\Models\Withdrawal::query()->where('status', \Larva\Wallet\Models\Withdrawal::STATUS_SUCCEEDED)->whereDate('created_at', $this->yesterday)->sum('amount');
                //统计积分收入
                $finance->integral_income = \Larva\Integral\Models\Recharge::query()->where('status', \Larva\Integral\Models\Recharge::STATUS_SUCCEEDED)->whereDate('created_at', $this->yesterday)->sum('amount');
                //统计积分提现
                $finance->integral_withdrawal = \Larva\Integral\Models\Withdrawal::query()->where('status', \Larva\Integral\Models\Recharge::STATUS_SUCCEEDED)->whereDate('created_at', $this->yesterday)->sum('amount');
                $finance->save();
            }
            $this->info('[' . date('Y-m-d H:i:s', time()) . ']统计完成!');
        } catch (\Exception $exception) {
            $this->error('执行统计失败：' . $exception->getMessage());
        }
    }
}
