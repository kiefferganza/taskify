<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskInterface
{
    public function getAllByUser($user): Collection
    {
        return $user->tasks;
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
    }

    public function delete(Task $task)
    {
        $task->delete();
    }
}
