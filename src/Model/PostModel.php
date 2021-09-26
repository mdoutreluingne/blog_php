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
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC LIMIT 3";

        return $this->database->getAllData($query);
    }
}
