<?php

namespace App\Repositories;
use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getAll($status = null, $pageSize = 10, $id = null, $page = 1);
    public function create(array $data);
    public function update(Task $task, array $dataToUpdate);
    public function delete(string $id);
}
