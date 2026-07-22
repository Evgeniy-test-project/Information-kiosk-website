<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class KioskSetting extends Model
{
    use AsSource;
    protected $fillable = ['key', 'value'];
}
