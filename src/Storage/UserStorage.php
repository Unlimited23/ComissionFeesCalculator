<?php

namespace App\Storage;

/**
 * Stores all unique users
 *
 * @author Petyo Ruzhin
 */
class UserStorage
{
    private $users;

    public function getUser($userId)
    {
        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }

        return false;
    }

    public function setUser($userId, $user)
    {
        $this->users[$userId] = $user;
    }
}
