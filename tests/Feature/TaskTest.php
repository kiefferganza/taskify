<?php

namespace Tests\Feature;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Interfaces\TaskInterface;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private TaskInterface $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepository = app(TaskInterface::class);
    }

    /** @test */
    public function it_can_get_all_tasks_of_a_user()
    {
        $user = $this->signIn();

        $tasks = Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('tasks.index'));

        $response->assertSuccessful();

        $response->assertJsonCount(3);

        $response->assertJson($tasks->toArray());
    }

    /** @test */
    public function it_can_create_a_new_task()
    {
        $user = $this->signIn();

        $taskData = Task::factory()->raw(['user_id' => $user->id]);

        $response = $this->postJson(route('tasks.store'), $taskData);

        $response->assertSuccessful();

        $response->assertJson($taskData);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $user = $this->signIn();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $updatedTaskData = Task::factory()->raw();

        $response = $this->putJson(route('tasks.update', $task->id), $updatedTaskData);

        $response->assertSuccessful();

        $response->assertJson($updatedTaskData);

        $this->assertDatabaseHas('tasks', $updatedTaskData);
    }

    /** @test */
    public function it_can_delete_a_task()
    {
        $user = $this->signIn();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson(route('tasks.destroy', $task->id));

        $response->assertSuccessful();

        $this->assertDatabaseMissing('tasks', $task->toArray());
    }

    private function signIn()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}
