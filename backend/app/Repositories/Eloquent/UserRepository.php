<?php

namespace App\Repositories\Eloquent;

use App\Filters\UserFilter;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    public function updateUser(string $uuid, array $data): int
    {
        return $this->model->where('uuid', $uuid)->update($data);
    }

    public function findUserByUuid(string $uuid): User
    {
        return $this->model->findByUuid($uuid);
    }

    public function findUserByUuidMorph(string $uuid, User $model): User
    {
        return $model->findByUuid($uuid);
    }

    public function findUserByEmail(string $email): User | null
    {
        return $this->model->where('email', $email)->whereNull('inactivated_at')->first();
    }

    public function getUsers(array $filter = []): Collection
    {
        return $this->model->latest()->filter($filter, UserFilter::class)->get();
    }

    public function inactivateUser(string $uuid): int
    {
        return $this->model->where('uuid', $uuid)->update([
            'inactivated_at' => now()
        ]);
    }

    public function deleteUser(string $uuid): int
    {
        return $this->model->where('uuid', $uuid)->delete();
    }
}
