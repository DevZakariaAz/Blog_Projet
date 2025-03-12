<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;


class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::All();
        return view("admin.comment.index", compact("comments"));
    }

    public function indexByArticle(Article $article)
    {
        $comments = $article->comments;
        return view("admin.comment.indexByArticle", compact("comments", "article"));
    }

    public function create()
    {
        // Implementation for creating a comment (not provided)
    }

    public function show(Comment $comment)
    {
        return view("admin.comment.show", compact("comment"));
    }

    public function edit(Comment $comment)
    {
        return view("admin.comment.edit", compact("comment"));
    }

    public function update(CommentRequest $request, Comment $comment)
    {

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('comment.show', $comment)
            ->with('success', 'Commentaire modifié avec succès.');
    }

    public function store(CommentRequest $request, $articleId)
    {
        $article = Article::findOrFail($articleId);

        $article->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('public.public.show', $article->id)
            ->with('success', 'Your comment has been added!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('comment.index')
            ->with('success', 'Commentaire supprimé avec succès.');
    }

    public function destroyByArticle(Comment $comment)
    {
        $article = $comment->article;
        $comment->delete();

        return redirect()
            ->route('comment.indexByArticle', $article)
            ->with('success', 'Commentaire supprimé avec succès.');
    }
}
