<?php

namespace App\Dto;

use App\Models\TaskStatusEnum;

/**
 * @OA\Schema(
 *     schema="UpdateTaskDto",
 *     title="UpdateTaskDto",
 *     type="object",
 *     @OA\Property(property="title", type="string", example="Atualizar tarefa"),
 *     @OA\Property(property="description", type="string", example="Nova descrição da tarefa", nullable=true),
 *     @OA\Property(property="status", type="string", enum={"pending", "done"}, example="done")
 * )
 */
class UpdateTaskDto
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?TaskStatusEnum $status = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }
}
