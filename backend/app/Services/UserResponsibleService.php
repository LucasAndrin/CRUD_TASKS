<?php

namespace App\Services;

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
}
