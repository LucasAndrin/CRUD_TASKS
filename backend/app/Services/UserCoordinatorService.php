<?php

namespace App\Services;

use App\Models\Task;
use App\Models\UserCoordinator;
use App\Models\UserResponsible;
use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserCoordinatorService
{
    private TaskRepository $taskRepository;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository(new Task);
        $this->userCoordinatorRepository = new UserRepository(new UserCoordinator);
        $this->userResponsibleRepository = new UserRepository(new UserResponsible);
    }

    public function getTasks(string|null $search): Collection
    {
        return $this->taskRepository->getTasksFilterableWith([
            'descript' => $search
        ], ['responsible', 'creator']);
    }

    public function getReponsibles(): Collection
    {
        return $this->userResponsibleRepository->getUsers();
    }

    public function createTask(string $description, string $creatorUuid, string $responsibleUuid): Task
    {
        $coordinator = $this->userCoordinatorRepository->findUserByUuid($creatorUuid);
        $responsible = $this->userResponsibleRepository->findUserByUuid($responsibleUuid);

        return $this->taskRepository->createTask([
            'description' => $description,
            'created_by' => $coordinator->id,
            'responsible_id' => $responsible->id
        ]);
    }

    public function updateTask(string $uuid, string $description): int
    {
        return $this->taskRepository->updateTaskByUuid($uuid, [
            'description' => $description
        ]);
    }
}
