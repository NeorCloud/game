<?php

namespace App\Domains\Settings\Http\Controllers;

use App\Domains\Settings\Http\Requests\UpdateSettingRequest;
use App\Domains\Settings\Models\Setting;
use App\Domains\Settings\Services\SettingService;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * @var SettingService
     */
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.settings.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function index2list()
    {
        $settings = Setting::query();

        return datatables()->of($settings)
            ->editColumn('created_at', function ($setting) {
                return verta($setting->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d');
            })
            ->editColumn('updated_at', function ($setting) {
                return verta($setting->updated_at)->timezone(config('app.timezone'))->format('H:i y/m/d');
            })
            ->addColumn('actions', function ($setting) {
                return
                    '<div class="btn-group" role="group">' .
                    '<a href="' . route('admin.settings.show', $setting->id) . '" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i>
                     </a>
                     <a href="' . route('admin.settings.edit', $setting->id) . '" class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i>
                     </a>
                     </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param Setting $setting
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Setting $setting)
    {
        return view('backend.settings.show', compact('setting'));
    }

    /**
     * @param Setting $setting
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Setting $setting)
    {
        return view('backend.settings.edit', compact('setting'));
    }

    /**
     * @param UpdateSettingRequest $request
     * @param Setting $setting
     * @return mixed
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $this->settingService->update($setting, $request->validated());

        return redirect()->route('admin.settings.show', $setting->id)->withFlashSuccess(__('Setting Updated!'));
    }
}
