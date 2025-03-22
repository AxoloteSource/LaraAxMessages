<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldTypes extends Model
{
    /** @use HasFactory<\Database\Factories\FieldTypesFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
