<?php

namespace Modules\Blog\Controllers;

use Modules\Blog\Models\Comment;
use Modules\Blog\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index()
    {
        $comments = $this->commentService->getAllComments();
        return view('Blog::admin.comment.index', compact('comments'));
    }

    public function create()
    {
        return view('Blog::admin.comment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->commentService->createComment($validated);

        return redirect()->route('comment.index')->with('success', 'Commentaire créé avec succès.');
    }

    public function show(Comment $comment)
    {
        return view('Blog::admin.comment.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        return view('Blog::admin.comment.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $this->commentService->updateComment($comment, $validated);

        return redirect()->route('comment.index');
    }

    public function destroy(Comment $comment)
    {
        $this->commentService->deleteComment($comment);
        return redirect()->route('comment.index');
    }
}
