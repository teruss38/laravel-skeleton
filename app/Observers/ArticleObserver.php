<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Article;
use App\Services\FileService;
use Larva\Censor\Censor;
use Larva\Censor\CensorNotPassedException;

/**
 * 文章观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleObserver
{
    /**
     * Handle the "saving" event.
     *
     * @param Article $article
     * @return void
     */
    public function saving(Article $article)
    {
        $censor = Censor::getFacadeRoot();
        try {
            $article->title = $censor->textCensor($article->title);
            if ($censor->isMod) {//如果标题命中了关键词就放入待审核
                $article->status = Article::STATUS_UNAPPROVED;
            }
        } catch (CensorNotPassedException $e) {
            $article->status = Article::STATUS_REJECTED;
        }
    }

    /**
     * 处理「强制删除」事件
     *
     * @param Article $article
     * @return void
     * @throws \Exception
     */
    public function forceDeleted(Article $article)
    {
        if ($article->user_id) {
            \App\Models\UserExtra::dec($article->user_id, 'articles');
        }
        //删除缩略图
        if ($article->thumb_path) {
            FileService::deleteFile($article->thumb);
        }
        //删除附加表
        if ($article->detail) {
            //删除附件
            $files = FileService::getLocalFilesByContent($article->detail->content);
            foreach ($files as $file) {
                FileService::deleteFile($file);
            }
            $article->detail->delete();
        }
    }
}
