<?php

namespace Modules\Blog\App\Imports;

use Modules\Blog\Models\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticlesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        // Ensure the columns match with your Excel file
        return new Article([
            'title'       => $row['title'],
            'content'     => $row['content'] ,
            'category_id' => $row['category_id'],
            'user_id'     => $row['user_id'],
        ]);
    }
}
