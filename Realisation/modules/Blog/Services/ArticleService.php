<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function store($validatedData)
    {
        $article = Article::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category'],
            'user_id' => Auth::id(),
        ]);

        $article->tags()->sync($validatedData['tags']);

        return $article;
    }

    public function update(Article $article, $validatedData)
    {
        $article->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category'],
        ]);
        if (Auth::id() === $article->user_id) {
            return $article->update(); // Allow update if the user is the owner
        }

        $article->tags()->sync($validatedData['tags']);

        return $article;
    }

    public function destroy(Article $article)
    {
        if (Auth::id() === $article->user_id) {
            return $article->delete(); // Allow deletion if the user is the owner
        }
        $article->tags()->detach(); 
        $article->delete();
    }
}
