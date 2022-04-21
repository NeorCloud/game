<?php

namespace App\Domains\Files\Http\Controllers;

use App\Domains\Files\Http\Requests\StoreFileRequest;
use App\Domains\Files\Http\Requests\StreamPrivateFilesRequest;
use App\Domains\Files\Http\Requests\UpdateFileRequest;
use App\Domains\Files\Models\File;
use App\Domains\Files\Services\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * @var FileService
     */
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $index = $request->input('index');

        return view('backend.files.index', compact('index'));
    }

    public function index2list(Request $request)
    {
        $index = $request->input('index');
        $index != 'deleted' ? $files = $this->fileService->query() : $files = $this->fileService->trashed();

        return datatables()->of($files)
            ->editColumn('title', function ($file) {
                if ($file->deleted_at == null) {
                    return '<a class="link" href="' . route('admin.files.show', $file->id) . '">' . $file->title . '</a>';
                } else {
                    return $file->title;
                }
            })
            ->editColumn('creator', function ($file) {
                return $file->creator->name;
            })
            ->addColumn('action', function ($file) use ($index) {
                $restore = '';
                $edit = '';
                if ($index == 'deleted') {
                    $restore = '<a class="btn btn-primary btn-sm"
                                       href="' . route('admin.files.restore', $file->id) . '"
                                       title="' . __('Restore') . '"><i class="fas fa-sync-alt"></i>
                                    </a>';
                } else {
                    $edit = '<a class="btn btn-primary btn-sm"
                                       href="' . route('admin.files.edit', $file->id) . '"
                                       title="' . __('Edit') . '"><i class="fas fa-edit"></i>
                                    </a>
                             <a class="btn btn-info btn-sm" title="'. $file->src .'"
                                       href="'. $file->src.'"><i class="fas fa-eye"></i></a>';
                }
                $index == 'deleted' ? $text = __('Its not restorable') : $text = '';

                return '<div class="btn-group" role="group">
                            <form method="POST" action="' . route($index != 'deleted' ? 'admin.files.destroy' : 'admin.files.hardDelete', $file->id) . '">
                                ' . csrf_field() . '
                                ' . method_field('delete') . '
                                <div class="btn-group" role="group">
                                    ' . $edit . $restore . '
                                    <button type="button" class="btn btn-danger btn-sm"
                                            title="' . __('Delete') . '"
                                            data-toggle="modal" data-target="#delete-' . $file->id . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="modal fade" id="delete-' . $file->id . '" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">' . __('Sure') . '</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ' . __('Are you sure') . '
                                                <br>
                                                ' . $text . '
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">' . __('No') . '
                                                </button>
                                                <button type="submit"
                                                        class="btn btn-success">' . __('Yes') . '</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>';
            })
            ->editColumn('created_at', function ($file) {
                return verta($file->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d');
            })
            ->editColumn('deleted_at', function ($file) {
                return verta($file->deleted_at)->timezone(config('app.timezone'))->format('H:i y/m/d');
            })
            ->editColumn('type', function ($file) {
                return __($file->type);
            })
            ->rawColumns(['title', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest $request
     * @throws \Throwable
     */
    public function store(StoreFileRequest $request)
    {
        $fileName = time() . '-' . $request->file->getClientOriginalName();
        $request->file('file')->storeAs($request->input('type') . '/uploads', $fileName);
        $file = $this->fileService->store($request->validated(), $fileName);

        return response()->json(['success' => __('Done'), 'id' => $file->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param File $file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return view('backend.files.show', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param File $file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        return view('backend.files.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFileRequest $request
     * @param File $file
     * @return void
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        $this->fileService->update($file, $request->validated());

        return redirect()->route('admin.files.show', $file->id)->withFlashSuccess(__('File information successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $this->fileService->delete($file);

        return redirect()->route('admin.files.index', ['index' => 'deleted'])->withFlashSuccess(__('File successfully deleted.'));
    }

    /**
     * @param $deletedFile
     * @throws \App\Exceptions\GeneralException
     */
    public function restore($deletedFile)
    {
        $file = $this->fileService->trashed()->findOrFail($deletedFile);
        $this->fileService->restore($file);

        return redirect()->route('admin.files.show', $file->id)->withFlashSuccess(__('File successfully restored.'));
    }

    public function hardDelete($deletedFile)
    {
        $file = $this->fileService->trashed()->findOrFail($deletedFile);
        $this->fileService->hardDelete($file);

        return redirect()->route('admin.files.index', ['index' => 'deleted'])->withFlashSuccess(__('File successfully deleted.'));
    }

    public function streamPrivateFile(StreamPrivateFilesRequest $request)
    {
        $file = $this->fileService->getById($request->input('id'));

        return Storage::response($file->type.'/uploads/'.$file->filename, $file->filename, [
            'Content-type: '. $file->format,
        ]);
    }
}
