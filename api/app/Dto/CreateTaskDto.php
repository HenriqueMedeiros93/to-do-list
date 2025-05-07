<?php

namespace App\Dto;

use App\Models\TaskStatusEnum;

 /**
     * @OA\Schema(
     *     schema="CreateTaskDto",
     *     title="CreateTaskDto",
     *     type="object",
     *     required={"title", "status"},
     *     @OA\Property(property="title", type="string", example="Estudar Laravel"),
     *     @OA\Property(property="description", type="string", example="Revisar código", nullable=true),
     *     @OA\Property(property="status", type="string", enum={"pending", "done"}, example="pending")
     * )
     */
class CreateTaskDto
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public TaskStatusEnum $status = TaskStatusEnum::Pending 
    ) 
     {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }
}
