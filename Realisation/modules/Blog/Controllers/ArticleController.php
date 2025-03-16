<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Modules\Blog\App\Requests\ArticleRequest;
use Modules\Blog\Services\ArticleService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Modules\Blog\App\Exports\ArticlesExport;
use Modules\Blog\App\Imports\ArticlesImport;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('crud_search_input') && !empty($request->crud_search_input)) {
            $query->where('title', 'like', '%' . $request->crud_search_input . '%');
        }

        $articles = $query->with(['category', 'user'])->paginate(4);

        return view('Blog::admin.article.index', compact('articles'));
    }


    public function create()
    {
        return view('Blog::admin.article.create', [
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    public function store(ArticleRequest $request)
    {
        // Call the service method to store the article
        $this->articleService->store($request->validated());

        return redirect()->route('article.index')->with('success', 'Article added successfully.');
    }

    public function show(Article $article)
    {
        return view('Blog::admin.article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('Blog::admin.article.edit', [
            'article' => $article,
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        // Call the service method to update the article
        $this->articleService->update($article, $request->validated());

        return redirect()->route('article.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        // Call the service method to destroy the article
        $this->articleService->destroy($article);

        return redirect()->route('article.index')->with('success', 'Article deleted successfully.');
    }

public function import(ArticleRequest $request)
{
    if ($request->isImport()) {
        Excel::import(new ArticlesImport, $request->file('file'));
        return redirect()->route('article.index')->with('success', 'Articles imported successfully.');
    }

    return back()->withErrors(['file' => 'No valid file was provided.']);
}

    public function export($format = 'xlsx')
    {
        $allowedFormats = ['csv', 'xlsx'];

        if (!in_array($format, $allowedFormats)) {
            return redirect()->back()->with('error', 'Invalid format.');
        }

        return Excel::download(new ArticlesExport, "articles.$format", $format === 'csv' ? \Maatwebsite\Excel\Excel::CSV : \Maatwebsite\Excel\Excel::XLSX);
    }
}
