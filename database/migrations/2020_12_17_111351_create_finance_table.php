<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance', function (Blueprint $table) {
            $table->id();
            $table->decimal('wallet_income', 10, 2)->comment('钱包充值金额');
            $table->decimal('wallet_withdrawal', 10, 2)->comment('钱包提现金额');
            $table->decimal('integral_income', 10, 2)->comment('积分充值金额');
            $table->decimal('integral_withdrawal', 10, 2)->comment('积分提现金额');
            $table->date('created_at')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance');
    }
}
