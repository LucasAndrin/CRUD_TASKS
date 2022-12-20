<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;

/**
 * Class AuthService.
 */
class AuthService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(new User());
    }

    public function login(string $email): array
    {
        $user = $this->userRepository->findUserByEmail($email);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function register(array $data): array
    {
        $user = $this->userRepository->create($data);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
