<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findUserByEmail(string $email): User | null;
}
