<?php

namespace App\Domain\Excel\Services;

use App\Domain\Excel\Enums\FileTypes;
use App\Domain\Excel\Handlers\ImportHandlerFactory;
use Illuminate\Http\UploadedFile;

class ExcelService
{
    public function import(FileTypes $type, string $disk, string $filePath): void
    {
        $handlerFactory = new ImportHandlerFactory();
        $handlerFactory->make($type)->import($filePath, $disk);
    }

    public function tempSaveUploadedFile(UploadedFile $file): string
    {
        $randomName = uniqid().'.'.$file->getClientOriginalExtension();

        return $file->storeAs('/', $randomName, ['disk' => 'temp']);
    }
}
