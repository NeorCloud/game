<?php


namespace App\Domains\Games\Services;

use App\Domains\Games\Models\Game;
use App\Domains\Games\Models\GameLog;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;

class GameLogService extends BaseService
{
    /**
     * SettingService constructor.
     *
     * @param GameLog $log
     */
    public function __construct(GameLog $log)
    {
        $this->model = $log;
    }

    public function query()
    {
        return $this->model->query();
    }

    public function store(Game $game, array $data = [])
    {
        if ($data['nickname'] == null || $data['user_agent'] == null || $data['ip'] == null)
            throw new GeneralException(__('nickname or user_agent or ip cant be null'));
        DB::beginTransaction();
        try {
            $log = $game->logs()->create([
                'nickname' => $data['nickname'],
                'user_agent' => $data['user_agent'],
                'ip' => $data['ip'],
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem in creating this game log. Please try again.'));
        }
        DB::commit();

        return $log;
    }

    public function update(GameLog $log, array $data = []): GameLog
    {
        if ($data['score'] == null || $data['duration'] == null)
            throw new GeneralException(__('score or duration cant be null for updating game log'));
        DB::beginTransaction();
        try {
            $log->update([
                'score' => $data['score'],
                'duration' => $data['duration'],
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem in updating this game log. Please try again.'));
        }

        DB::commit();

        return $log;
    }
}
