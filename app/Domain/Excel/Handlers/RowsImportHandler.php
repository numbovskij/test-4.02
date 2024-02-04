<?php

namespace App\Domain\Excel\Handlers;

use App\Domain\Excel\Handlers\AbstractImportHandler;
use App\Domain\Excel\Models\Excel;
use DateInterval;
use DateTime;

class RowsImportHandler extends AbstractImportHandler
{
    /**
     * @throws \Exception
     */
    public function model(array $row): Excel
    {
        $date = $row['date'];
        if (is_float($date) || is_numeric($date)) {
            if ($date > 60) {
                $date--;
            }
            // The base date for Excel is 1900-01-01
            $baseDate = DateTime::createFromFormat('Y-m-d', '1899-12-31');
            // Add the Excel date (number of days since base date)
            $dateInterval = new DateInterval(sprintf('P%dD', $date));
            $baseDate->add($dateInterval);
            $date = $baseDate->format('Y-m-d');
        }

        return new Excel([
            'id' => intval($row['id']) + $this->getRowNumber() - 1,
            'name' => $row['name'],
            'date' => $date,
        ]);
    }
}
