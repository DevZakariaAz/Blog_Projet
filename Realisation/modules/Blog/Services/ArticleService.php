<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    public function store($validatedData)
    {
        // Create a new article
        $article = Article::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category'],
            'user_id' => Auth::id(),
        ]);

        // Attach tags to the article (many-to-many relationship)
        $article->tags()->sync($validatedData['tags']);

        return $article;
    }

    public function update(Article $article, $validatedData)
    {
        // Update the article's properties
        $article->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category'],
        ]);

        // Sync the tags
        $article->tags()->sync($validatedData['tags']);

        return $article;
    }

    public function destroy(Article $article)
    {
        $article->tags()->detach(); 
        $article->delete();
    }
}
