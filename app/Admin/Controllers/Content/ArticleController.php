<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Content;

use App\Admin\Actions\Grid\BatchRestore;
use App\Admin\Actions\Grid\ForceDelete;
use App\Admin\Actions\Grid\Restore;
use App\Admin\Actions\Grid\ReviewAccept;
use App\Admin\Actions\Grid\ReviewReject;
use App\Models\Article;
use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

/**
 * 文章管理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return '文章';
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Article::with(['category', 'tags', 'user']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');

            $grid->filter(function (Grid\Filter $filter) {
                //右侧搜索
                $filter->equal('id');
                $filter->equal('title');
                $filter->scope('pending', '待审核')->where('status', Article::STATUS_PENDING);
                $filter->scope('rejected', '已拒绝')->where('status', Article::STATUS_REJECTED);
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->quickSearch(['id', 'title']);

            $grid->column('id', 'ID')->sortable();
            $grid->column('user.username', '作者');
            $grid->column('category.name', '文章类别');
            $grid->column('title', '标题');
            $grid->column('tag_values', '标签');
            $grid->column('views', '查看数');
            $grid->column('comment_count', '评论数');
            $grid->column('support_count', '点赞数');
            $grid->column('collection_count', '收藏数');
            $grid->column('status', '状态')->using(Article::getStatusLabels())->dot(Article::getStatusDots(), 'info');
            $grid->column('order', '排序权重')->editable();
            $grid->column('created_at', '发布时间')->sortable();
            $grid->paginate(10);
            //待审核
            if (request('_scope_') == 'pending') {
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new ReviewAccept(Article::class));
                    $actions->append(new ReviewReject(Article::class));
                });
            } else if (request('_scope_') == 'trashed') {// 回收站
                $grid->tools(function (Grid\Tools $tools) {
                    $tools->append(new ForceDelete(Article::class));
                });
                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->append(new Restore(Article::class));
                });
                $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                    $batch->add(new BatchRestore(Article::class));
                });
            }
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(Article::with(['category', 'tags', 'detail']), function (Form $form) {
            $form->block(8, function (Form\BlockForm $form) {
                $form->showFooter();
                $form->tab('基本信息', function (Form\BlockForm $form) {
                    $form->hidden('user_id')->value(Auth::guard('admin')->user()->getAuthIdentifier());
                    $form->text('title', '标题')->required()->rules('required|string|max:40|min:5')->placeholder('请输入文字标题（5-30个汉字）');
                    $form->editor('detail.content', '内容')->required()->placeholder('请输入正文');
                })->tab('Metas', function (Form\BlockForm $form) {
                    $form->embeds('metas', false, function ($form) {
                        $form->text('title', 'Title');
                        $form->text('keywords', 'Keywords');
                        $form->textarea('description', 'Description')->rows(3);
                    });
                })->tab('扩展', function (Form\BlockForm $form) {
                    $form->embeds('detail.extra', false, function ($form) {
                        $form->text('from', '来源名');
                        $form->text('from_url', '来源网址');
                        $form->switch('bd_daily', '百度快速收录')->default(0);
                    });
                });
            });

            $form->block(4, function (Form\BlockForm $form) {
                $form->radio('status', '状态')->options(Article::getStatusLabels())->default(Article::STATUS_ACCEPTED);
                //$form->switch('recommend', '推荐');
                $form->select('category_id', '栏目')->options(Category::selectOptions())->required();
                $form->tags('tag_values', '标签')->ajax('api/tags', 'name', 'name');
                $form->image('thumb_path', '特色图像')->rules('file|image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
                $form->textarea('description', '摘要')->rows(3);
                $form->number('order', '排序权重')->default(0);
            });
        });
    }
}
