<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    protected TaskInterface $taskRepository;

    public function __construct(TaskInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->getAllByUser(auth()->user());
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $taskData = $request->all();
        $taskData['user_id'] = auth()->user()->id;

        $task = $this->taskRepository->create($taskData);

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $taskData = $request->all();

        $this->taskRepository->update($task, $taskData);

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->taskRepository->delete($task);
    }
}
