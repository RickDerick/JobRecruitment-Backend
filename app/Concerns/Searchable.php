<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Schema;

trait Searchable
{
    public static bool $searchable = false;

    public static function searchFields(): array
    {
        return Schema::getColumnListing(static::class);
    }
}
