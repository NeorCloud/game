<?php

namespace App\Domains\Backups\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.backups.index');
    }

    public function index2list()
    {
        $txt = config('app.name');
        $txt = str_replace(' ', '-', $txt);
        $filesTmp = Storage::files($txt);
        $files = [];
        $i = 0;
        foreach ($filesTmp as $file) {
            $name = str_replace($txt . '/', '', $file);
            $date = explode('-', str_replace('.zip', '', $name));
            $time = $date[0] . '-' . $date[1] . '-' . $date[2] . ' ' . $date[3] . ':' . $date[4] . ':' . $date[5];
            $files[$i] = [
                'name' => $name,
                'created_at' => verta($time)->timezone(config('app.timezone'))->format('H:i y/m/d'),
            ];
            $i++;
        }
        rsort($files);

        return datatables()->of($files)
            ->addColumn('title', function ($file) {
                return $file['name'];
            })
            ->addColumn('created_at', function ($file) {
                return $file['created_at'];
            })
            ->addColumn('size', function ($file) use ($txt) {
                $byte = Storage::size($txt . '/' . $file['name']);
                if ($byte / 1024 > 1) {
                    if ($byte / 1024 / 1024 > 1) {
                        if ($byte / 1024 / 1024 / 1024 > 1) {
                            $number = $byte / 1024 / 1024 / 1024;
                            $type = 'GB';
                        } else {
                            $number = $byte / 1024 / 1024;
                            $type = 'MB';
                        }
                    } else {
                        $number = $byte / 1024;
                        $type = 'KB';
                    }
                } else {
                    $number = $byte;
                    $type = 'B';
                }

                return number_format($number, '2').$type;
            })
            ->addColumn('action', function ($file) {
                return '<div class="btn-group" role="group">
                              <a class="btn btn-primary btn-sm"
                                 href="' . route('admin.backups.download', $file['name']) . '"
                                 title="' . __('Download') . '">
                                    <i class="fas fa-download"></i>
                              </a>
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param $backup
     * @return \never|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($backup)
    {
        $txt = config('app.name');
        $txt = str_replace(' ', '-', $txt);
        if (Storage::exists($txt . '/' . $backup)) {
            return Storage::download($txt . '/' . $backup);
        }

        return abort(404);
    }
}
