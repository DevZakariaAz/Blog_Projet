<?php

namespace Modules\Blog\App\Imports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Blog\Models\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticlesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info($row); 

        return new Article([
            'title'        => $row['title'] ?? null,
            'content'      => $row['content'] ?? null,
            'user_id'      => Auth::id(), // Assuming the current user is the author
            'category_id'  => $row['category_id'] ?? null, // Fix undefined key issue
        ]);
    }
}
