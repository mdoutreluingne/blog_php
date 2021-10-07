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

    /**
     * Display all the posts
     * @return array|mixed
     */
    public function listComments()
    {
        $query = "SELECT comment.*, user.last_name, user.first_name, post.title FROM " . $this->table . " JOIN user ON user.id = comment.user_id JOIN post ON post.id = comment.post_id ORDER BY comment.created_at DESC";

        return $this->database->getAllData($query);
    }

    /**
     * Display a comment
     * @param int $int
     * @return array|mixed
     */
    public function findCommentById(int $id)
    {
        $query = "SELECT comment.*, user.last_name, user.first_name, post.title FROM " . $this->table . " JOIN user ON user.id = comment.user_id JOIN post ON post.id = comment.post_id WHERE comment.id = " . $id;

        return $this->database->getAllData($query);
    }
}
