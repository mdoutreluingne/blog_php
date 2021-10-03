<?php

namespace App\Model;

/**
 * Class PostModel
 * Manages User Data
 * @package App\Model
 */
class CommentModel extends MainModel
{
    /**
     * Display a post
     * @param int $id
     * @return array|mixed
     */
    public function findComentByPost(int $id)
    {
        $query = "SELECT comment.*, user.last_name, user.first_name FROM " . $this->table . " JOIN user ON user.id = comment.user_id WHERE comment.validated = 1 AND comment.post_id = " . $id;

        return $this->database->getAllData($query);
    }

    /**
     * Count comment by post
     * @param int $id
     * @return array|mixed
     */
    public function countCommentByPost(int $id)
    {
        $query = "SELECT COUNT(*) as countComment FROM " . $this->table . " WHERE comment.validated = 1 AND post_id = " . $id;

        return $this->database->getAllData($query);
    }
}
