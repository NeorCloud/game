<?php


namespace App\Domains\Games\Services;

use App\Domains\Games\Models\Game;
use App\Services\BaseService;

class GameService extends BaseService
{
    /**
     * SettingService constructor.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->model = $game;
    }

    public function query()
    {
        return $this->model->query();
    }
}
