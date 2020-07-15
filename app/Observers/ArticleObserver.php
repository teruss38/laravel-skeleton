<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\Article;
use App\Models\UserExtra;
use Larva\Censor\Censor;
use Larva\Censor\CensorNotPassedException;
use Illuminate\Support\Facades\Cache;

/**
 * Article 观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\Article $article
     * @return void
     */
    public function created(Article $article)
    {
        if (empty($article->description)) {//自动提取摘要
            $description = str_replace(array("\r\n", "\t", '&ldquo;', '&rdquo;', '&nbsp;'), '', strip_tags($article->content));
            $article->description = mb_substr($description, 0, 200);
            $article->save();
        }
        if ($article->user_id) {
            UserExtra::inc($article->user_id, 'articles');
        }
        $censor = Censor::getFacadeRoot();
        try {
            $article->content = $censor->checkText($article->content);
            if ($censor->isMod) {//需要审核
                $article->status = Article::STATUS_PENDING;
            }
        } catch (CensorNotPassedException $e) {
            $article->status = Article::STATUS_REJECTED;
        }
        if ($article->status == Article::STATUS_ACCEPTED) {
//            if ($article->recommend) {
//                BaiduPing::pushRealtime($article->link);//推天级收录
//            } else {
//                BaiduPing::pushBatch($article->link);//推周级收录
//            }
        }
        $article->save();
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\Models\Article $article
     * @return void
     */
    public function updated(Article $article)
    {

    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\Article $article
     * @return void
     * @throws \Exception
     */
    public function deleted(Article $article)
    {
        if ($article->user_id) {
            UserExtra::dec($article->user_id, 'articles');
        }
    }
}
