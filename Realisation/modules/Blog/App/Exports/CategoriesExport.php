<?php

namespace Modules\Blog\App\Exports;

use Modules\Blog\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Category::select('id', 'name','slug', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Category Name','Slug', 'Created At'];
    }
}
