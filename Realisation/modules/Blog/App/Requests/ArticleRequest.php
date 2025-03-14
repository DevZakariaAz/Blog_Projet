<?php

namespace Modules\Blog\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'file' => 'nullable|file|mimes:xlsx,xls,csv',  // Add validation for import files
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'content.required' => 'Le contenu est requis.',
            'content.string' => 'Le contenu doit être une chaîne de caractères.',
            'category.required' => 'La catégorie est requise.',
            'category.exists' => 'La catégorie sélectionnée est invalide.',
            'tags.array' => 'Les tags doivent être un tableau.',
            'tags.*.exists' => 'Un ou plusieurs tags sont invalides.',
            'file.mimes' => 'Le fichier doit être au format CSV, XLSX ou XLS.',  // Custom validation message for the import file
        ];
    }

    /**
     * Determine if the import file is valid.
     *
     * @return bool
     */
    public function isImport(): bool
    {
        return $this->hasFile('file') && $this->file('file')->isValid();
    }
}
