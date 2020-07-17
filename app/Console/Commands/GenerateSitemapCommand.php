<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Laravelium\Sitemap\Sitemap;

/**
 * 生成站点地图
 * @author Tongle Xu <xutongle@gmail.com>
 */
class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sitemap Daily';

    /**
     * @var int
     */
    protected $mapChunk = 1000;

    /**
     * @var string
     */
    protected $storePath = '';

    /**
     * @var string
     */
    protected $baiduStorePath = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->storePath = public_path('sitemap');
        if (!is_dir($this->storePath)) {
            @mkdir($this->storePath, 0755, true);
        }
        $this->baiduStorePath = public_path('sitemap-baidu');
        if (!is_dir($this->baiduStorePath)) {
            @mkdir($this->baiduStorePath, 0755, true);
        }
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']开始执行 sitemap 生成脚本');
        try {
            $this->build();
            $this->buildBaidu();
            $this->info('[' . date('Y-m-d H:i:s', time()) . ']生成 sitemap 成功!');
        } catch (\Exception $exception) {
            $this->error('生成 sitemap 失败：' . $exception->getMessage());
        }
    }

    /**
     * 编译普通站点地图
     */
    protected function build()
    {
        /** @var Sitemap $sitemap */
        $sitemap = App::make('sitemap');

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to('/'), now()->toRfc3339String(), '1.0', 'daily');
        $sitemap->add(URL::route('article.index'), now()->toRfc3339String(), '0.8', 'daily');

        $sitemap->store('xml', 'misc', $this->storePath);
        $sitemap->addSitemap(secure_url('sitemap/misc.xml'), now()->toRfc3339String());
        $sitemap->model->resetItems();

        // counters
        $counter = 0;
        Article::accepted()->orderBy('id')->chunk($this->mapChunk, function ($items) use ($sitemap, &$counter) {
            foreach ($items as $item) {
                $sitemap->add($item->link, $item->created_at->toRfc3339String(), '0.6', 'always');
            }
            $sitemap->store('xml', $counter, $this->storePath);
            $sitemap->addSitemap(secure_url('sitemap/' . $counter . '.xml'), now()->toRfc3339String());
            $sitemap->model->resetItems();
            $counter++;
        });

        // you need to check for unused items
        if (!empty($sitemap->model->getItems())) {
            $sitemap->store('xml', $counter, $this->storePath);
            $sitemap->addSitemap(secure_url('sitemap/' . $counter . '.xml'), now()->toRfc3339String());
            $sitemap->model->resetItems();
        }
        $sitemap->store('sitemapindex', 'sitemap');

    }

    /**
     * 编译百度专用地图
     */
    protected function buildBaidu()
    {
        /** @var Sitemap $sitemap */
        $sitemap = App::make('sitemap');

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to('/'), now()->toRfc3339String(), '1.0', 'daily');
        $sitemap->add(URL::route('article.index'), now()->toRfc3339String(), '0.8', 'daily');

        $sitemap->store('baidu', 'misc', $this->baiduStorePath);
        $sitemap->addSitemap(secure_url('sitemap-baidu/misc.xml'), now()->toRfc3339String());
        $sitemap->model->resetItems();

        // counters
        $counter = 0;
        Article::accepted()->orderBy('id')->chunk($this->mapChunk, function ($items) use ($sitemap, &$counter) {
            foreach ($items as $item) {
                $sitemap->add($item->link, $item->created_at->toRfc3339String(), '0.6', 'always');
            }
            $sitemap->store('baidu', $counter, $this->baiduStorePath);
            $sitemap->addSitemap(secure_url('sitemap-baidu/' . $counter . '.xml'), now()->toRfc3339String());
            $sitemap->model->resetItems();
            $counter++;
        });

        // you need to check for unused items
        if (!empty($sitemap->model->getItems())) {
            $sitemap->store('baidu', $counter, $this->baiduStorePath);
            $sitemap->addSitemap(secure_url('sitemap-baidu/' . $counter . '.xml'), now()->toRfc3339String());
            $sitemap->model->resetItems();
        }
        $sitemap->store('sitemapindex', 'sitemap-baidu');
    }
}
