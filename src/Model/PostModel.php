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
     * @param string $value
     * @param string $key
     * @return array|mixed
     */
    public function listLastPosts()
    {
        $query = "SELECT post.*, user.last_name, user.first_name FROM " . $this->table . " JOIN user ON user.id = post.user_id ORDER BY created_at DESC LIMIT 3";

        return $this->database->getAllData($query);
    }

    /**
     * Display all the posts
     * @param string $value
     * @param string $key
     * @return array|mixed
     */
    public function listPosts()
    {
        $query = "SELECT post.*, user.last_name, user.first_name FROM " . $this->table . " JOIN user ON user.id = post.user_id ORDER BY created_at DESC";

        return $this->database->getAllData($query);
    }
}
