<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TaskModel",
 *     title="Task",
 *     type="object",
 *     required={"title", "status"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Estudar Laravel"),
 *     @OA\Property(property="description", type="string", example="Revisar controllers, services e repositórios"),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Task extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($task) {
            if (empty($task->id)) {
                $task->id = (string) Str::uuid();
            }
        });
    }
}
