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
use App\Models\ArticleMod;
use Larva\Censor\Censor;
use Larva\Censor\CensorManager;
use Larva\Censor\CensorNotPassedException;

/**
 * 文章详情观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleDetailObserver
{
    /**
     * Handle the "saved" event.
     *
     * @param ArticleDetail $articleDetail
     * @return void
     */
    public function saved(ArticleDetail $articleDetail)
    {
        $censor = Censor::getFacadeRoot();
        try {
            $articleDetail->content = $censor->textCensor($articleDetail->content);
            if ($censor->isMod) {//需要审核
                $articleDetail->article->status = Article::STATUS_UNAPPROVED;
            }
        } catch (CensorNotPassedException $e) {
            $articleDetail->article->status = Article::STATUS_REJECTED;
        }

        // 记录触发的审核词
        if ($articleDetail->article->status === Article::STATUS_UNAPPROVED && $censor->wordMod) {
            if (($stopWords = $articleDetail->stopWords) == null) {
                $stopWords = new ArticleMod(['article_id' => $articleDetail->article_id]);
            }
            $stopWords->stop_word = implode(',', array_unique($censor->wordMod));
            $stopWords->save();
        }

        //保存并且不再触发 事件
        $articleDetail->saveQuietly();
        $articleDetail->article->saveQuietly();

        //推送
        if ($articleDetail->article->status == Article::STATUS_APPROVED && !config('app.debug')) {
            if ($articleDetail->extra['bd_daily']) {
                //BaiduPush::daily($articleDetail->article->link);//推快速收录
            } else {
                //BaiduPush::push($articleDetail->article->link);//推普通收录
            }
            //BingPush::push($articleDetail->article->link);//推普通收录
        }
    }
}
