<?php
namespace App\Http\Controllers;

use App\Dto\CreateTaskDto;
use App\Dto\UpdateTaskDto;
use App\Models\TaskStatusEnum;
use App\Services\TaskServiceInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Lista de tarefas (to do list)",
 *     version="1.0.0",
 *     description="Documentação para teste de lista de tarefas",
 * )
 */
class TodoListController
{
    public function __construct(protected TaskServiceInterface $service)
    {}
/**
 * @OA\Get(
 *     path="/api/task",
 *     summary="Listar todas as atividades",
 *     tags={"TodoList"},
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="string", enum={"pending", "done"})
 *     ),
 *     @OA\Parameter(
 *         name="pageSize",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="integer", default=10, description="Número de itens por página")
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         @OA\Schema(type="integer", default=1, description="Número da página")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de tarefas com paginação e filtro",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TaskModel")),
 *             @OA\Property(property="page", type="integer"),
 *             @OA\Property(property="lastPage", type="integer"),
 *             @OA\Property(property="pageSize", type="integer"),
 *             @OA\Property(property="total", type="integer")
 *         )
 *     )
 * )
 */
    public function getTasks(Request $request)
    {
        $status  = $request->query('status');
        $pageSize = $request->query('pageSize', 10);
        $page    = $request->query('page', 1);

        return response()->json(
            $this->service->list(
                status: $status,
                pageSize: $pageSize,
                page: $page
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/task",
     *     summary="Criar uma nova tarefa",
     *      tags={"TodoList"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateTaskDto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/TaskModel")
     *     )
     * )
     */
    public function createTask(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,done',
        ]);

        $createTaskDto = new CreateTaskDto(
            title: $request->input(key: 'title'),
            description: $request->input(key: 'description', default:null),
            status: TaskStatusEnum::from(value: $request->input(key: 'status', default:TaskStatusEnum::Pending->value))
        );

        return response()->json(data: $this->service->create(createTaskDto: $createTaskDto));
    }

    /**
     * @OA\Put(
     *     path="/api/task/{id}",
     *     summary="Atualiza uma  tarefa",
     *      tags={"TodoList"},
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskDto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/TaskModel")
     *     )
     * )
     */
    public function updateTask(Request $request, $id)
    {
        $updateTaskDto = new UpdateTaskDto(
            title: $request->input(key: 'title'),
            description: $request->input(key: 'description', default:null),
            status: TaskStatusEnum::from(value: $request->input(key: 'status', default:TaskStatusEnum::Pending->value))
        );

        return response()->json(data: $this->service->update(id: $id, updateTaskDto: $updateTaskDto));
    }

    /**
     * @OA\Delete(
     *     path="/api/task/{id}",
     *     summary="Deletar uma tarefa",
     *     tags={"TodoList"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(response=204, description="Deletado")
     * )
     */
    public function deleteTask($id)
    {
        return response()->json($this->service->delete(id: $id));
    }
}
