<?php
namespace App\Repositories;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Exception;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll($status = null, $pageSize = 10, $id = null, $page = 1)
    {
        try {
            if ($id) {
                return Task::where(column: 'id', operator: $id)->first();       
            }
    
            $query = Task::query();
    
            if ($status) {
                $query->where(column: 'status', operator: $status);
            }
    
        
            $query->orderBy('created_at', 'desc');  
    
            $page = max(1, (int) $page);
    
            $result = $query->paginate(perPage: $pageSize, columns: ['*'], pageName: 'page', page: $page);
    
            if ($result->isEmpty() && $page > 1) {
                $page--;
                $result = $query->paginate(perPage: $pageSize, columns: ['*'], pageName: 'page', page: $page);
            }
    
            return $result;
        } catch (Exception $e) {
            throw new Exception(message: $e['message'] ?? 'Ocorreu um erro ao tentar recuperar as tarefas.');
        }
    }

    public function create(array $data):Task
    {
        try {
            return Task::create(attributes: $data);
        } catch (Exception $e) {
            throw new Exception(message: $e['message'] ?? 'Ocorreu um erro ao tentar recuperar as tarefas.');
        }
    }

    public function update(Task $task, array $dataToUpdate):Task
    {
        try {
            $task->update(attributes: $dataToUpdate);
            return $task;
        } catch (Exception $e) {
            throw new Exception(message: $e['message'] ?? 'Ocorreu um erro ao tentar recuperar as tarefas.');
        }
    }

    public function delete(string $id):bool|null
    {
        try {
            $task = Task::findOrFail(id: $id);
            return $task->delete();
        } catch (Exception $e) {
            throw new Exception(message: $e['message'] ?? 'Ocorreu um erro ao tentar recuperar as tarefas.');
        }
    }
}
