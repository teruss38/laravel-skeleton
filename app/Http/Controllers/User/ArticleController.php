<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

/**
 * 前台文章模型
 * @author Tongle Xu <xutongle@gmail.com>
 */
class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'category', 'show', 'tag']);
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the article.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $items = Article::approved()->with('user')->orderByDesc('order')->orderByDesc('id')->paginate(15);
        $categories = Category::getRootNodes();
        return view('article.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $categories = Category::getRootNodes();
        return view('article.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created article in storage.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->except(['content']));
        if ($article && $article->detail()->create($request->only(['content']))) {
            $message = '文章发布成功！为了确保文章的质量，我们会对您发布的文章进行审核。请耐心等待......';
            $this->flash()->info($message);
            return redirect()->route('articles.show', $article);
        }
        $this->flash()->error('文章发布失败，请稍后再试!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified article.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Article $article)
    {
        $categories = Category::getRootNodes();
        return view('article.edit', [
            'categories' => $categories,
            'article' => $article
        ]);
    }

    /**
     * Update the specified article in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        if ($article->update($request->except(['content'])) && $article->detail->update($request->only(['content']))) {
            $message = '文章更新成功！为了确保文章的质量，我们会对您发布的文章进行审核。请耐心等待......';
            $this->flash()->info($message);
            return redirect()->route('articles.show', $article);
        }
        $this->flash()->error('文章更新失败，请稍后再试!');
        return redirect()->back();
    }

    /**
     * Remove the specified article from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
