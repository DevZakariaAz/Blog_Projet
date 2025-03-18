<?php

namespace Modules\Blog\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug'  => 'required|string|max:255|unique:tags,slug,' . ($this->tag ? $this->tag->id : 'NULL') . ',id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis.',
            'title.max'      => 'Le titre ne peut pas dépasser 255 caractères.',
            'slug.required'  => 'Le slug est requis.',
            'slug.max'       => 'Le slug ne peut pas dépasser 255 caractères.',
            'slug.unique'    => 'Ce slug existe déjà, choisissez un autre.',
        ];
    }
}
