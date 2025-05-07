<?php

namespace App\Services;

use App\Dto\CreateTaskDto;
use App\Dto\UpdateTaskDto;

interface TaskServiceInterface
{
    public function list($status = null, $pageSize = 10, $page = 1);
    public function create(CreateTaskDto $createTaskDto);
    public function update(string $id, UpdateTaskDto $updateTaskDto);
    public function delete(string $id);
}
