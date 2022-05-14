<?php

namespace App\Domains\Games\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLog extends Model
{
    use HasFactory;

    protected $table = 'game_logs';

    protected $fillable = [
        'nickname',
        'score',
        'duration',
        'user_agent',
        'ip',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getRankingAttribute()
    {
        return $this->game->logs()->where('score','>',$this->score)->count() +1;
    }
}
