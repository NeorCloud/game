<?php


namespace App\Domains\Settings\Services;

use App\Domains\Settings\Models\Setting;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;

class SettingService extends BaseService
{
    /**
     * SettingService constructor.
     *
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Throwable
     */
    public function store(array $data = []): Setting
    {
        if ($data['title'] == null || $data['value'] == null)
            throw new GeneralException(__('title or value cant be null'));
        \DB::beginTransaction();
        try {
            $setting = $this->createSetting([
                'title' => $data['title'],
                'description' => $data['description'],
                'value' => $data['title'],
            ]);
        } catch (Exception $e) {
            \DB::rollBack();

            throw new GeneralException(__('There was a problem in creating this setting. Please try again.'));
        }
        \DB::commit();

        return $setting;
    }

    /**
     * @param Setting $setting
     * @param array $data
     * @return Setting
     * @throws GeneralException|\Throwable
     */
    public function update(Setting $setting, array $data = []): Setting
    {
        if ($data['title'] == null || $data['value'] == null)
            throw new GeneralException(__('title or value cant be null'));
        \DB::beginTransaction();
        try {
            $setting->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'value' => $data['value'],
            ]);
        } catch (Exception $e) {
            \DB::rollBack();

            throw new GeneralException(__('There was a problem in updating this setting. Please try again.'));
        }

        \DB::commit();

        return $setting;
    }

    /**
     * @param  array  $data
     * @return Setting
     */
    protected function createSetting(array $data = []): Setting
    {
        return $this->model::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'value' => $data['value'],
        ]);
    }
}
