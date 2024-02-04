<?php

declare(strict_types=1);

namespace App\Domain\Excel\Controllers;

use App\Domain\Excel\Enums\FileTypes;
use App\Domain\Excel\Repositories\ExcelRepository;
use App\Domain\Excel\Requests\ExcelRequest;
use App\Domain\Excel\Services\ExcelService;
use App\Http\Controllers\Controller;
use App\Jobs\ImportJob;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ExcelController extends Controller
{
    public function __construct(
        private readonly ExcelRepository $excelRepository,
        private readonly ExcelService $service,
    ) {
    }

    public function index(): ViewContract
    {
        $rows = $this->excelRepository->allGroupedByDate();

        return View::make('excel', [
            'items' => $rows->toArray(),
        ]);
    }

    public function upload(ExcelRequest $request): JsonResponse
    {
        $filePath = $this->service->tempSaveUploadedFile($request->file('file'));

        ImportJob::dispatch('temp', $filePath, $request->enum('type', FileTypes::class));

        return new JsonResponse([], ResponseAlias::HTTP_ACCEPTED);
    }
}
