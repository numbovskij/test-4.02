<?php

namespace App\Domain\Excel\Models;

use App\Events\RowCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

class Excel extends Model
{
    protected $fillable = [
        'id',
        'name',
        'date',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (self $row) {
            Event::dispatch(new RowCreated($row));
        });
    }
}
