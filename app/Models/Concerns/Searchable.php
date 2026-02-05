<?php

namespace App\Models\Concerns;

trait Searchable
{
    public function toSearchableArray(): array
    {
        return $this->toArray();
    }
}
