<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Actions\Content;

use App\Models\Article;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

/**
 * 文字审核
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleVerify extends RowAction
{

    /**
     * 按钮标题
     *
     * @var string
     */
    protected $title = '审核';


    /**
     * 是否显示
     * @return bool|mixed
     */
    public function allowed()
    {
        return $this->row->pending;
    }

    /**
     * 设置确认弹窗信息，如果返回空值，则不会弹出弹窗
     *
     * 允许返回字符串或数组类型
     *
     * @return array|string|void
     */
    public function confirm()
    {
        return [
            // 确认弹窗 title
            "您确定要审核通过吗？",
            // 确认弹窗 content
            $this->row->title,
        ];
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return \Dcat\Admin\Actions\Response
     */
    public function handle(Request $request)
    {
        // 复制数据
        Article::find($this->getKey())->update(['status' => Article::STATUS_ACCEPTED]);
        // 返回响应结果并刷新页面
        return $this->response()->success("已审核")->refresh();
    }
}
