<?php

namespace App\Jobs;

use App\Domain\Excel\Enums\FileTypes;
use App\Domain\Excel\Services\ExcelService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $disk,
        private readonly string $filePath,
        private readonly FileTypes $type,
    )
    {
    }

    public function handle(): void
    {
        App::make(ExcelService::class)->import($this->$type, $this->disk, $this->filePath);
    }
}
