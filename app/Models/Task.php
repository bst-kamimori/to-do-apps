<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'progress',
        'remarks',
        'created_at',
        'updated_at',
        'is_completed',
        'operation_id'
    ];

    // end_date を Carbon インスタンスとして扱うためにキャストを追加
    protected $casts = [
        'is_completed' => 'boolean',
        'end_date' => 'date',
    ];

    public function project_name(): BelongsTo
    {
        return $this->belongsTo(ProjectName::class, 'project_name_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }
}
