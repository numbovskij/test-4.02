<?php

namespace App\Domain\Excel\Handlers;

use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterBatch;
use Maatwebsite\Excel\Importer;
use Maatwebsite\Excel\Validators\Failure;

abstract class AbstractImportHandler implements ToModel, SkipsEmptyRows, WithBatchInserts,
                                                WithChunkReading, WithHeadingRow, WithCalculatedFormulas,
                                                WithEvents, SkipsOnFailure
{
    use RegistersEventListeners, RemembersRowNumber;
    use Importable {
        import as private originalImport;
    }

    private string $disk;
    private string $filePath;
    private ?string $readerType;
    private string $hash;

    public function import(string $filePath, string $disk, ?string $readerType = null): Importer|PendingDispatch
    {
        $this->disk = $disk;
        $this->filePath = $filePath;
        $this->readerType = $readerType;
        $this->hash = Storage::disk($disk)->checksum($filePath);

        return $this->originalImport($filePath, $disk, $readerType);
    }

    public function afterBatch(AfterBatch $afterBatch): void
    {
        Redis::command(
            'SET',
            [
                sprintf(
                    'import_progress.%s.%s',
                    static::class,
                    $this->hash,
                ),
                sprintf('%d', $this->getRowNumber()),
            ],
        );
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onFailure(Failure ...$failures)
    {
    }
}
