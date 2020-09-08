<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 文件处理
 * @author Tongle Xu <xutongle@gmail.com>
 */
class FileService
{
    /**
     * 处理 Html 内容中的远程资源到本地,并自动将第一张图作为缩略图
     * @param string $content
     * @return string[]
     */
    public static function handleContentRemoteFile($content)
    {
        // 匹配<img>、src，存入$matches数组,
        $p = '/<img.*[\s]src=[\"|\'](.*)[\"|\'].*>/iU';
        $num = preg_match_all($p, $content, $matches);
        if ($num) {
            foreach ($matches[1] as $src) {
                if (isset($src) && strpos($src, config('filesystems.disks.' . config('filesystems.cloud') . '.url')) === false) {
                    $ext = File::extension($src);
                    $file_content = static::getRemoteFile($src);
                    if ($ext) {
                        $path = 'images/' . date('Y/m/') . Str::random(40) . '.' . $ext;
                    } else {
                        $path = 'images/' . date('Y/m/') . Str::random(40);
                    }
                    if ($file_content && Storage::cloud()->put($path, $file_content)) {
                        Storage::cloud()->setVisibility($path, Filesystem::VISIBILITY_PUBLIC);
                        $url = Storage::cloud()->url($path);
                        $content = str_replace($src, $url, $content);
                    }
                }
            }
        }
        return $content;
    }

    /**
     * 保存远程文件
     * @param string $url
     * @return mixed
     */
    public static function saveRemoteFile($url)
    {
        $ext = File::extension($url);
        $file_content = static::getRemoteFile($url);
        if ($ext) {
            $path = 'images/' . date('Y/m/') . Str::random(40) . '.' . $ext;
        } else {
            $path = 'images/' . date('Y/m/') . Str::random(40);
        }
        if ($file_content && Storage::cloud()->put($path, $file_content)) {
            Storage::cloud()->setVisibility($path, Filesystem::VISIBILITY_PUBLIC);
            $url = Storage::cloud()->url($path);
        }
        return $url;
    }

    /**
     * 模拟浏览器下载远程文件
     * @param string $url
     * @return false|string
     */
    public static function getRemoteFile($url)
    {
        $content = false;
        try {
            $content = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 Edg/84.0.522.59',
            ])->retry(2, 100)->get($url)->throw()->body();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return $content;
    }
}
