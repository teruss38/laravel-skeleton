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

/**
 * 文章观察者
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param Article $article
     * @return void
     */
    public function created(Article $article)
    {
        //远程图片本地化
        $article->detail->content = FileService::handleContentRemoteFile($article->detail->content);

        //自动提取缩略图
        if (empty($article->thumb_path)) {
            if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $article->detail->content, $matches)) {
                $article->thumb_path = $matches[3][0];
            }
        }

        //自动提取摘要
        if (empty($article->description)) {
            $description = str_replace(array("\r\n", "\t", '&ldquo;', '&rdquo;', '&nbsp;'), '', strip_tags($article->detail->content));
            $article->description = mb_substr($description, 0, 190);
        }

        if ($article->status == Article::STATUS_ACCEPTED && !config('app.debug')) {
            if ($article->detail->extra['bd_daily']) {
                //BaiduPush::daily($article->link);//推快速收录
            } else {
                //BaiduPush::push($article->link);//推普通收录
            }
            //BingPush::push($article->link);//推普通收录
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
        //删除附件
        if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $article->detail->content, $matches)) {
            foreach ($matches[3] as $img) {
                FileService::deleteFile($img);
            }
        }
    }
}
