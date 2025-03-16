<?php

namespace Modules\Blog\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'tags' => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
        ];
    }

    // Optionally, you can define custom validation messages
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'content.required' => 'Content cannot be empty.',
            'category.required' => 'Category must be selected.',
            'tags.required' => 'At least one tag is required.',
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
