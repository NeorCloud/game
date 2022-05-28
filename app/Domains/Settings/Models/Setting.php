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
 * 1: panel logo
 * 2: login logo
 * 3: Ad image in game pages
 * 4: Ad image in game pages link
 * 5: Yektanet ad in bottom of game page
*/
