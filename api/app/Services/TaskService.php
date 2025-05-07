<?php

namespace App\Services;

use App\Dto\CreateTaskDto;
use App\Repositories\TaskRepositoryInterface;
use App\Dto\PaginatedTaskDto;
use App\Dto\UpdateTaskDto;
use App\Services\TaskServiceInterface;
use App\Models\Task;
use Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;

class TaskService implements TaskServiceInterface
{
    public function __construct(protected TaskRepositoryInterface $repo) {}  

    public function list($status = null, $pageSize = 10,  $page = 1): PaginatedTaskDto
    {
        $tasks = $this->repo->getAll(status: $status, pageSize: $pageSize, page: $page);
    
        return new PaginatedTaskDto(
            tasks: $tasks->items(),
            totalPage: $tasks->lastPage(),
            currentPage: $tasks->currentPage(),
            totalTasks:$tasks->total(),
        );
    }
    
    public function create(CreateTaskDto $createTaskDto)
    {     
       return $this->repo->create(data: [
            'title' => $createTaskDto->title,
            'status' => $createTaskDto->status->value, 
            'description' => $createTaskDto->description
        ]);
    }

    public function update(String $id, UpdateTaskDto $updateTaskDto)
    {
        $task = $this->repo->getAll(id: $id);
    
        $dataToUpdate = array_filter([
            'title' => $updateTaskDto->title,
            'description' => $updateTaskDto->description,
            'status' => $updateTaskDto->status?->value,
        ], fn ($value) => $value !== null);
    
        $task = $this->repo->update(task: $task, dataToUpdate: $dataToUpdate);

        return new Task( attributes: [$task]);
    }

    public function delete(String $id)
    {
        return $this->repo->delete(id: $id);
    }
}
