<?php

namespace Modules\Blog\App\Imports;

use Illuminate\Support\Str;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class ArticlesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $categoryName = $row['category'] ?? 'Default Category'; 
        $slug = Str::slug($categoryName, '-'); 
        
        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => $slug] 
        );

        $user_id = Auth::id();

        $article = Article::create([
            'title' => $row['title'],
            'content' => $row['content'],
            'category_id' => $category->id, 
            'user_id' => $user_id,  
        ]);
    $tags = isset($row['tags']) ? explode(',', $row['tags']) : [];

    $tagIds = [];
    foreach ($tags as $tagName) {
        $tag = Tag::firstOrCreate(['name' => $tagName]); // Create tag if it doesn't exist
        $tagIds[] = $tag->id;
    }

    $article->tags()->sync($tagIds); // Sync tags with the article

        return $article;
    }
}
