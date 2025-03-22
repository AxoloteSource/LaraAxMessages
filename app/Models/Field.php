<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    /** @use HasFactory<\Database\Factories\FieldFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'field_type_id',
    ];

    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(FieldTypes::class);
    }
}
