<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\Tag;
use Modules\Blog\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = $this->tagService->getAllTags();
        return view('Blog::admin.tag.index', compact('tags'));
    }

    public function create()
    {
        return view('Blog::admin.tag.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug'  => 'required|max:255',
        ]);

        $this->tagService->createTag($validated);

        return redirect()->route('tag.index')->with('success', 'Catégorie créé avec succès.');
    }

    public function show(Tag $tag)
    {
        return view('Blog::admin.tag.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('Blog::admin.tag.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug'  => 'required|max:255',
        ]);

        $this->tagService->updateTag($tag, $validated);

        return redirect()->route('tag.index');
    }

    public function destroy(Tag $tag)
    {
        $this->tagService->deleteTag($tag);
        return redirect()->route('tag.index');
    }
}
