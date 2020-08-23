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
use App\Services\FileService;
use Larva\Censor\Censor;
use Larva\Censor\CensorNotPassedException;

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
        //远程图片本地化
        $article->content = FileService::handleContentRemoteFile($article->content);

        //自动提取缩略图
        if (empty($article->thumb_path)) {
            if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $article->content, $matches)) {
                $article->thumb_path = $matches[3][0];
            }
        }

        //自动提取摘要
        if (empty($article->description)) {
            $description = str_replace(array("\r\n", "\t", '&ldquo;', '&rdquo;', '&nbsp;'), '', strip_tags($article->content));
            $article->description = mb_substr($description, 0, 190);
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
        $article->save();

        if ($article->status == Article::STATUS_ACCEPTED && !config('app.debug')) {
//            if ($article->recommend) {
//                BaiduPush::daily($article->link);//推快速收录
//            } else {
//                BaiduPush::push($article->link);//推普通收录
//                BingPush::push($article->link);//推普通收录
//            }
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\Models\Article $article
     * @return void
     */
    public function updated(Article $article)
    {
        if ($article->status == Article::STATUS_ACCEPTED && !config('app.debug')) {
//            BaiduPush::push($article->link);//推普通收录
//            BingPush::push($article->link);//推普通收录
        }
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
        if ($article->status == Article::STATUS_ACCEPTED && !config('app.debug')) {
//            BingPush::push($article->link);//推普通收录
        }
    }
}
