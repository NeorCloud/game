<?php


namespace App\Domains\Files\Services;

use App\Domains\Files\Models\File;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Storage;

class FileService extends BaseService
{
    /**
     * SettingService constructor.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->model = $file;
    }

    /**
     * @param array $data
     * @param string $fileName
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data, string $fileName): File
    {
        if ($data['title'] == null || $data['type'] == null) {
            throw new GeneralException(__('title or type cant be null'));
        }
        if ($data['type'] != 'public' && $data['type'] != 'private') {
            throw new GeneralException(__('Type should to be public or private.'));
        }
        \DB::beginTransaction();

        try {
            $file = $this->createFile([
                'title' => $data['title'],
                'description' => $data['description'],
                'type' => $data['type'],
                'filename' => $fileName,
            ]);
        } catch (Exception $e) {
            \DB::rollBack();

            throw new GeneralException(__('There was a problem in creating this setting. Please try again.'));
        }
        \DB::commit();

        return $file;
    }

    /**
     * @param File $file
     * @param array $data
     * @return File
     * @throws GeneralException|\Throwable
     */
    public function update(File $file, array $data = []): File
    {
        \DB::beginTransaction();

        try {
            $file->update([
                'title' => $data['title'],
                'description' => $data['description'],
            ]);
        } catch (Exception $e) {
            \DB::rollBack();

            throw new GeneralException(__('There was a problem in updating this file information. Please try again.'));
        }

        \DB::commit();

        return $file;
    }

    /**
     * @param File $file
     * @return File
     * @throws GeneralException
     */
    public function delete(File $file)
    {
        if ($this->deleteById($file->id)) {
            return $file;
        }

        throw new GeneralException('There was a problem deleting this file. Please try again.');
    }

    /**
     * @param File $file
     * @return bool
     * @throws GeneralException
     */
    public function hardDelete(File $file): bool
    {
        if ($file->forceDelete()) {
            Storage::delete($file->type.'/uploads/'.$file->filename);
            return true;
        }

        throw new GeneralException('There was a problem deleting this file. Please try again.');
    }

    /**
     * @param File $deletedFile
     * @return File
     * @throws GeneralException
     */
    public function restore(File $deletedFile)
    {
        if ($deletedFile->restore()) {
            return $deletedFile;
        }

        throw new GeneralException(__('There was a problem restoring this file. Please try again.'));
    }

    /**
     * @param  array  $data
     * @return File
     */
    protected function createFile(array $data = []): File
    {
        return $this->model::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'filename' => $data['filename'],
        ]);
    }

    public function query()
    {
        return $this->model::query();
    }

    public function trashed()
    {
        return $this->model::onlyTrashed();
    }
}
