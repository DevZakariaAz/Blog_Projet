<?php

namespace Modules\Blog\App\Imports;

use Modules\Blog\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Category([
            'name' => $row['name'],
            'slug' => $row['slug'],
        ]);
    }
}
