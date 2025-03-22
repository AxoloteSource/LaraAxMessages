<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageStatus extends Model
{
    /** @use HasFactory<\Database\Factories\MessageStatusFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
