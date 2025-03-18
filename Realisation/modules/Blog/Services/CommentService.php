<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    public function getAllComments(int $perPage = 2): LengthAwarePaginator
    {
        return Comment::paginate($perPage);
    }

    public function createComment(array $data): Comment
    {
        return Comment::create([
            'content' => $data['content'],
            'post_id' => $data['post_id'],
            'user_id' => $data['user_id']
        ]);
    }

    public function updateComment(Comment $comment, array $data): bool
    {
        return $comment->update([
            'content' => $data['content'],
        ]);
    }

    public function deleteComment(Comment $comment): bool
    {
        return $comment->delete();
    }
}
