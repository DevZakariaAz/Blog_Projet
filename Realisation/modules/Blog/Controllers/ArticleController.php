<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Illuminate\Http\Request;
use Modules\Blog\App\Requests\ArticleRequest;
use Modules\Blog\Services\ArticleService;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Blog\App\Exports\ArticlesExport;
use Modules\Blog\App\Imports\ArticlesImport;
use Maatwebsite\Excel\Excel as ExcelFormat;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = Article::paginate(4);
        return view('Blog::admin.article.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('Blog::admin.article.create', compact('categories', 'tags'));
    }

    public function store(ArticleRequest $request)
    {
        $articleData = $request->validated();
        $articleData['category_id'] = $request->category;
        $this->articleService->store($articleData);

        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
    }

    public function show(Article $article)
    {
        return view('Blog::admin.article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('Blog::admin.article.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('edit', $article);

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $this->articleService->update($article, $validated);

        return redirect()->route('article.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $this->articleService->destroy($article);
        return redirect()->route('article.index')->with('success', 'Article supprimé avec succès.');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        Excel::import(new ArticlesImport, $file);
        return redirect()->route('article.index')->with('success', 'Articles imported successfully.');
    }

    public function export($format = 'xlsx')
    {
        
    $allowedFormats = ['csv', 'xlsx'];
    
    if (!in_array($format, $allowedFormats)) {
        return redirect()->back()->with('error', 'Invalid format selected.');
    }

        return Excel::download(new ArticlesExport, "articles.$format", $format === 'csv' ? ExcelFormat::CSV : ExcelFormat::XLSX);
        
    }
}
