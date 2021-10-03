<?php

namespace App\Model;

/**
 * Class PostModel
 * Manages User Data
 * @package App\Model
 */
class PostModel extends MainModel
{
    /**
     * Display the last 3 posts
     * @return array|mixed
     */
    public function listLastPosts()
    {
        $query = "SELECT post.*, user.last_name, user.first_name FROM " . $this->table . " JOIN user ON user.id = post.user_id ORDER BY updated_at DESC LIMIT 3";

        return $this->database->getAllData($query);
    }

    /**
     * Display all the posts
     * @return array|mixed
     */
    public function listPosts(int $firstPage, int $perPage)
    {
        $query = "SELECT post.*, user.last_name, user.first_name, (SELECT COUNT(c.post_id) FROM comment c WHERE c.post_id = post.id AND c.validated = 1) as countComment FROM " . $this->table . " JOIN user ON user.id = post.user_id ORDER BY post.updated_at DESC LIMIT " . $firstPage . ", " . $perPage;

        return $this->database->getAllData($query);
    }

    /**
     * Display a post
     * @param int $int
     * @return array|mixed
     */
    public function findPostById(int $id)
    {
        $query = "SELECT post.*, user.last_name, user.first_name FROM " . $this->table . " JOIN user ON user.id = post.user_id WHERE post.id = " . $id;

        return $this->database->getAllData($query);
    }

    /**
     * Count all the posts
     * @return array|mixed
     */
    public function countPost()
    {
        $query = "SELECT COUNT(*) AS count_posts FROM " . $this->table;

        return $this->database->getAllData($query);
    }
}
