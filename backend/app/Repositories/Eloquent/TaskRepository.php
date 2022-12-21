<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
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

    public function createTask($data): Task
    {
        return $this->model->create($data);
    }
}
