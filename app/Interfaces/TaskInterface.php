<?php

namespace App\Interfaces;

use App\Models\Task;

interface TaskInterface {
    public function getAllByUser($user);
    public function create(array $data);
    public function update(Task $task, array $data);
    public function delete(Task $task);
}
