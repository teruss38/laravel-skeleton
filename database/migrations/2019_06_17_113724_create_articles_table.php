<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id')->comment('栏目ID');
            $table->unsignedBigInteger('user_id')->nullable()->index()->comment('作者ID');
            $table->string('title')->comment('标题');
            $table->string('description')->nullable()->comment('描述');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->boolean('recommend')->default(false)->nullable()->comment('是否推荐');
            $table->unsignedInteger('order')->nullable()->default(0)->comment('排序');
            $table->unsignedInteger('views')->nullable()->default(0)->comment('查看次数');
            $table->unsignedInteger('comment_count')->nullable()->default(0)->comment('评论数量');
            $table->unsignedInteger('support_count')->nullable()->default(0)->comment('点赞数量');
            $table->unsignedInteger('collection_count')->nullable()->default(0)->comment('收藏数量');
            $table->unsignedTinyInteger('status');
            $table->json('seo')->nullable()->comment('SEO');
            $table->json('extra')->comment('扩展字段');
            $table->mediumText('content')->comment('内容');
            $table->timestamps();
            $table->index(['category_id', 'recommend', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
