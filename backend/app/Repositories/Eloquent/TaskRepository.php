<?php

namespace App\Repositories\Eloquent;

use App\Filters\TaskFilter;
use App\Models\Task;
use App\Models\UserAdmin;
use App\Models\UserCoordinator;
use App\Models\UserResponsible;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class TaskRepository.
 */
class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function getTasksFilterableWith(array|null $filter = null, array|string|null $with = null, array|string $get = ['*']): Collection
    {
        return $this->model->latest()->with($with)->filter($filter)->get($get);
    }

    public function getTasksFromUser(UserResponsible|UserCoordinator $user, array $filter = [], array|string|null $with = null): Collection
    {
        return $user->tasks()->with($with)->filter($filter, TaskFilter::class)->get();
    }

    public function createTask(array $data): Task
    {
        return $this->model->create($data);
    }

    public function updateTaskByUuid(string $uuid, array $data): int
    {
        return $this->model->where('uuid', $uuid)->update($data);
    }
}
