<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\UserResponsible;
use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserResponsibleService
{
    private TaskRepository $taskRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository(new Task);
        $this->userRepository = new UserRepository(new UserResponsible);
    }

    public function getTasks(string $uuid, string|null $search): Collection
    {
        $user = $this->userRepository->findUserByUuid($uuid);

        return $this->taskRepository->getTasksFromUser($user, [
            'description' => $search
        ], ['creator']);
    }

    public function markTaskAsProgress(string $taskUuid): int
    {
        return $this->taskRepository->updateTaskByUuid($taskUuid, [
            'status' => TaskStatus::Progress
        ]);
    }

    public function markAsStopped(string $taskUuid): int
    {
        return $this->taskRepository->updateTaskByUuid($taskUuid, [
            'status' => TaskStatus::Stopped
        ]);
    }

    public function markTaskAsCompleted(string $taskUuid): int
    {
        return $this->taskRepository->updateTaskByUuid($taskUuid, [
            'status' => TaskStatus::Completed
        ]);
    }
}
