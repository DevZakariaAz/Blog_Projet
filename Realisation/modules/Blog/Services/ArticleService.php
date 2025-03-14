<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService
{
    /**
     * Store a new article.
     */
    public function store(array $data)
    {
        $data['user_id'] = Auth::id();
        $article = Article::create($data);
        $this->syncTags($article, $data['tags']);
        return $article;
    }

    /**
     * Update an existing article.
     */
    public function update(Article $article, array $data)
    {
        $article->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'category_id' => $data['category'],
        ]);
        $this->syncTags($article, $data['tags']);
        return $article;
    }

    /**
     * Delete an article.
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }

    /**
     * Sync tags with article.
     */
    protected function syncTags(Article $article, array $tags)
    {
        if (!empty($tags)) {
            $article->tags()->sync($tags);
        }
    }
}
