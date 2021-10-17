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
     * @param int $idPost
     * @return array|mixed
     */
    public function findComentByPost(int $idPost)
    {
        $query = "SELECT comment.*, user.last_name, user.first_name FROM " . $this->table . " JOIN user ON user.id = comment.user_id WHERE comment.validated = 1 AND comment.post_id = " . $idPost;

        return $this->database->getAllData($query);
    }

    /**
     * Count comment by post
     * @param int $idPost
     * @return array|mixed
     */
    public function countCommentByPost(int $idPost)
    {
        $query = "SELECT COUNT(*) as countComment FROM " . $this->table . " WHERE comment.validated = 1 AND post_id = " . $idPost;

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
     * @param int $idComment
     * @return array|mixed
     */
    public function findCommentById(int $idComment)
    {
        $query = "SELECT comment.*, user.last_name, user.first_name, post.title FROM " . $this->table . " JOIN user ON user.id = comment.user_id JOIN post ON post.id = comment.post_id WHERE comment.id = " . $idComment;

        return $this->database->getAllData($query);
    }
}
