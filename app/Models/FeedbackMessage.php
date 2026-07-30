<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class FeedbackMessage extends Model
{
    use AsSource;
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
