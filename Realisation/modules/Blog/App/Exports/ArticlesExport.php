<?php

namespace Modules\Blog\App\Exports;

use Modules\Blog\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArticlesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Article::with(['category', 'tags'])->get()->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'category_name' => $article->category->name, 
                'tags' => $article->tags->pluck('name')->join(', '), 
                'created_at' => $article->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $article->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Content',
            'Category',
            'Tags',
            'Created At',
            'Updated At'
        ];
    }
}
