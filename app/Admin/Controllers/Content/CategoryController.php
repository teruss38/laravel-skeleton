<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Controllers\Content;

use App\Models\ArticleCategory;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;

/**
 * Class CategoryController
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CategoryController extends AdminController
{
    public function title()
    {
        return '栏目管理';
    }

    protected function grid()
    {
        return Grid::make(new ArticleCategory(), function (Grid $grid) {
            $grid->column('id', 'ID')->bold()->sortable();
            $grid->column('title', '栏目名称')->tree(); // 开启树状表格功能
            $grid->column('order', '排序')->orderable();
            $grid->column('created_at', '创建时间')->sortable();
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');
                $filter->like('description');
            });
            $grid->quickSearch(['id', 'title']);
            $grid->enableDialogCreate();
            $grid->disableViewButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Form::make(new ArticleCategory(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });
            $form->display('id', 'ID');
            $form->select('parent_id', '父栏目')->options(ArticleCategory::selectOptions())->default(0);
            $form->text('title', '栏目名称')->required()->placeholder('请输入栏目名称。');
            $form->image('image_path', '栏目图片')->rules('file|image')->dir('images/' . date('Y/m'))->uniqueName()->autoUpload();
            $form->textarea('description', '栏目描述')->required()->placeholder('请输入栏目描述。');
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
