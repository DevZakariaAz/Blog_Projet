<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Modules\Blog\App\Requests\ArticleRequest;
use Modules\Blog\Services\ArticleService;
use Modules\Blog\App\Exports\ArticlesExport;
use Modules\Blog\App\Imports\ArticlesImport;
use Maatwebsite\Excel\Excel;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = Article::paginate(7);
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
        $this->articleService->store($request->validated());
        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
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
        $this->authorize('edit', $article);
        $this->articleService->update($article, $request->validated());
        return redirect()->route('article.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $this->articleService->destroy($article);
        return redirect()->route('article.index')->with('success', 'Article supprimé avec succès.');
    }
    
    public function import(ArticleRequest $request)
    {
        if ($request->isImport()) {
            Excel::import(new ArticlesImport, $request->file('file'));
            return redirect()->route('article.index')->with('success', 'Articles imported successfully.');
        }

        return back()->withErrors(['file' => 'Aucun fichier valide n\'a été fourni.']);
    }

    public function export($format = 'xlsx')
    {
        $allowedFormats = ['csv', 'xlsx'];

        if (!in_array($format, $allowedFormats)) {
            return redirect()->back()->with('error', 'Format non autorisé.');
        }

        return Excel::download(new ArticlesExport, "articles.$format", $format === 'csv' ? Excel::CSV : Excel::XLSX);
    }
}
