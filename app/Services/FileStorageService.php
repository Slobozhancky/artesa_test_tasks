<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class FileStorageService
{
    protected $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/users.json'); // Шлях до файлу
    }

    public function saveUser($username, $password)
    {
        $users = $this->getUsers();
        $users[$username] = Hash::make($password);

        File::put($this->filePath, json_encode($users));
    }

    public function getUsers()
    {
        if (!File::exists($this->filePath)) {
            return [];
        }

        $users = json_decode(File::get($this->filePath), true);
        return $users !== null ? $users : [];
    }

    public function userExists($username)
    {
        $users = $this->getUsers();
        return array_key_exists($username, $users);
    }

    public function verifyUser($username, $password)
    {
        $users = $this->getUsers();
        return isset($users[$username]) && Hash::check($password, $users[$username]);
    }
}
