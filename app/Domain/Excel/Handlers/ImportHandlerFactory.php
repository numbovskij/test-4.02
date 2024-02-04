<?php

namespace App\Domain\Excel\Handlers;

use App\Domain\Excel\Enums\FileTypes;

class ImportHandlerFactory
{
    public function make(FileTypes $type): AbstractImportHandler
    {
        return match ($type) {
            FileTypes::Rows => new RowsImportHandler(),
        };
    }
}
