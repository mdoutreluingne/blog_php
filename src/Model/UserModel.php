<?php

namespace App\Model;

/**
 * Class UserModel
 * Manages User Data
 * @package App\Model
 */
class UserModel extends MainModel
{
    /**
     * Display all the users
     * @return array|mixed
     */
    public function listUsers()
    {
        $query = "SELECT user.* FROM " . $this->table . " ORDER BY user.last_name ASC ";

        return $this->database->getAllData($query);
    }
}
