<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackMessage extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'message',
        'email_sent',
        'is_read',
    ];

    protected $casts = [
        'email_sent' => 'boolean',
        'is_read' => 'boolean',
    ];
}
