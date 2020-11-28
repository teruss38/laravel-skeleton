<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Article;
use App\Models\ArticleDetail;
use App\Models\User;
use App\Services\FileService;
use Larva\Censor\Censor;
use Larva\Censor\CensorNotPassedException;

/**
 * Class ArticleDetailObserver
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleDetailObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param ArticleDetail $articleDetail
     * @return void
     */
    public function created(ArticleDetail $articleDetail)
    {
        $this->updateModel($articleDetail);
    }

    /**
     * 处理 更新」事件
     *
     * @param \App\Models\ArticleDetail $articleDetail
     * @return void
     */
    public function updated(ArticleDetail $articleDetail)
    {
        $this->updateModel($articleDetail);
    }

    /**
     * 更新模型
     * @param ArticleDetail $articleDetail
     */
    protected function updateModel(ArticleDetail $articleDetail)
    {
        //远程图片本地化
        $articleDetail->content = FileService::handleContentRemoteFile($articleDetail->content);

        //自动提取缩略图
        if (empty($articleDetail->article->thumb_path) && preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $articleDetail->content, $matches)) {
            $articleDetail->article->thumb_path = $matches[3][0];
        }

        //自动提取摘要
        if (empty($articleDetail->article->description)) {
            $description = str_replace(array("\r\n", "\t", '&ldquo;', '&rdquo;', '&nbsp;'), '', strip_tags($articleDetail->content));
            $articleDetail->article->description = mb_substr($description, 0, 190);
        }

        $censor = Censor::getFacadeRoot();
        try {
            $articleDetail->content = $censor->textCensor($articleDetail->article->title . $articleDetail->content);
            if ($censor->isMod) {//需要审核
                $articleDetail->article->status = Article::STATUS_PENDING;
            }
        } catch (CensorNotPassedException $e) {
            $articleDetail->article->status = Article::STATUS_REJECTED;
        }

        //保存并且不再触发 事件
        $articleDetail->saveQuietly();
        $articleDetail->article->saveQuietly();

        //推送
        if ($articleDetail->article->status == Article::STATUS_ACCEPTED && !config('app.debug')) {
            if ($articleDetail->extra['bd_daily']) {
                //BaiduPush::daily($articleDetail->article->link);//推快速收录
            } else {
                //BaiduPush::push($articleDetail->article->link);//推普通收录
            }
            //BingPush::push($articleDetail->article->link);//推普通收录
        }
    }
}
