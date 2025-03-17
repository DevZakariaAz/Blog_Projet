<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\App\Requests\TagRequest; 
use Modules\Blog\Models\Tag;
use Modules\Blog\Services\TagService;

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

    public function store(TagRequest $request)
    {
        $this->tagService->createTag($request->validated());

        return redirect()->route('tag.index')->with('success', 'Tag créé avec succès.');
    }

    public function show(Tag $tag)
    {
        return view('Blog::admin.tag.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('Blog::admin.tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $this->tagService->updateTag($tag, $request->validated());

        return redirect()->route('tag.index');
    }

    public function destroy(Tag $tag)
    {
        $this->tagService->deleteTag($tag);
        return redirect()->route('tag.index');
    }
}
