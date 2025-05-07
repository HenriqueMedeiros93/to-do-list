<?php

namespace App\Dto;

class PaginatedTaskDto
{
    public function __construct(
        public array $tasks,
        public int $totalPage,
        public int $currentPage,
        public int $totalTasks
    ) {}
}
