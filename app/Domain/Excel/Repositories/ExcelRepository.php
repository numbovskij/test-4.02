<?php

declare(strict_types=1);


namespace App\Domain\Excel\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ExcelRepository
{
    public function __construct(
        private readonly Row $model,
    ) {
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->newQuery()->with($relations)->limit(100)->get($columns);
    }

    public function find(int $id, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->newQuery()->with($relations)->select($columns)->find($id);
    }

    public function paginate(array $columns = ['*'], array $relations = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->with($relations)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, $columns);
    }

    public function allGroupedByDate(array $columns = ['*'], array $relations = [],): Collection
    {
        return $this->model->newQuery()->with($relations)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('date');
    }
}
