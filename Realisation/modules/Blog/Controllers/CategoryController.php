<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\Category;
use Modules\Blog\App\Requests\CategoryRequest;
use Modules\Blog\Services\CategoryService;
use Illuminate\Http\Request;
use Modules\Blog\App\Exports\CategoriesExport;
use Modules\Blog\App\Imports\CategoriesImport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::paginate(4);
        return view('Blog::admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('Blog::admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $this->categoryService->store($validated);

        return redirect()->route('category.index')->with('success', 'Catégorie créé avec succès.');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $this->categoryService->update($category, $validated);

        return redirect()->route('category.index');
    }

    public function show(Category $category)
    {
        return view('Blog::admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('Blog::admin.category.edit', compact('category'));
    }

    public function destroy(Category $category)
    {
        $this->categoryService->destroy($category);
        return redirect()->route('category.index');
    }
        public function export()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new CategoriesImport, $request->file('file'));

        return back()->with('success', 'Categories imported successfully!');
    }

}
