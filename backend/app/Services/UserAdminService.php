<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAdmin;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserAdminService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(new User);
    }

    public function getUsers(string $name = null): Collection
    {
        return $this->userRepository->getUsers([
            'name' => $name
        ]);
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type']
        ]);
    }

    public function deleteUser(string $uuid): int
    {
        $user = $this->userRepository->findUserByUuidMorph($uuid, new UserAdmin);

        if (($user->isCoordinator() || $user->isResponsible()) && $user->tasks()->count() || $user->isAdmin() && $user->users()->count()) {
            return $this->userRepository->inactivateUser($uuid);
        }

        return $this->userRepository->deleteUser($uuid);
    }
}
