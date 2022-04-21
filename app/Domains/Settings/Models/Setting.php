<?php

namespace App\Domains\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'value'];
}

/**
 * Settings docs by id:
*/
