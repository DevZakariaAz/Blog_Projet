<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class TagService
{
    public function getAllTags(int $perPage = 4): LengthAwarePaginator
    {
        return Tag::paginate($perPage);
    }

    public function createTag(array $data): Tag
    {
        return Tag::create([
            'name' => $data['title'],
            'slug' => $data['slug']
        ]);
    }

    public function updateTag(Tag $tag, array $data): bool
    {
        return $tag->update([
            'name' => $data['title'],
            'slug' => $data['slug']
        ]);
    }

    public function deleteTag(Tag $tag): bool
    {
        return $tag->delete();
    }
}
