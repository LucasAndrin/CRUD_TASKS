<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function findUserByEmail(string $email): User | null
    {
        return $this->model->where('email', $email)->first();
    }
}
