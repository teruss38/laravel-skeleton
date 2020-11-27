<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Observers;

use App\Models\ArticleDetail;
use App\Services\FileService;

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

        $articleDetail->article->save();
    }
}
