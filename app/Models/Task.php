<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /**
     * @var string $table
     */
    use HasFactory;

    /**
     * @var string[] $fillable
     */
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

    /**
     * @var string[] $casts
     */
    // end_dateをCarbonインスタンスとして扱うため追加
    protected $casts = [
        'is_completed' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * @return BelongsTo
     */
    public function project_name(): BelongsTo
    {
        return $this->belongsTo(ProjectName::class, 'project_name_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }
}
