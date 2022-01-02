<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @link https://laravel.com/docs/8.x/eloquent
 */
class AppHealth extends Model
{
    use HasFactory;

    protected $table = 'app_health';

    public $incrementing = false;
}
