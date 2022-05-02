<?php

namespace App\Domains\Games\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function logs()
    {
        return $this->hasMany(GameLog::class, 'game_id');
    }

    public function getPlayedTimeAttribute(): int
    {
        return $this->hasMany(GameLog::class, 'game_id')->count();
    }

    public function getDurationPlayedAttribute(): int
    {
        return $this->hasMany(GameLog::class, 'game_id')->sum('duration');
    }

    public function getSumScoresAttribute(): int
    {
        return $this->hasMany(GameLog::class, 'game_id')->sum('score');
    }

    public function getLinkAttribute(): string
    {
        return '<a href="'.route('admin.games.show', $this->id).'">'.$this->title.'</a>';
    }
}
