<?php

namespace App\Models;

enum TaskStatusEnum: string
{
    case Pending = 'pending';
    case Completed = 'done';
}
