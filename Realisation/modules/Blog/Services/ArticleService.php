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

        $article->tags()->sync($validatedData['tags']);

        return $article;
    }

    public function destroy(Article $article)
    {
        $article->tags()->detach(); 
        $article->delete();
    }
}
