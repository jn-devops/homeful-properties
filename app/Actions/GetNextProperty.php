<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Homeful\Properties\Models\Property;

class GetNextProperty
{
    use AsAction;

    public function handle(string $sku): ?Property
    {
        return Property::where('sku', $sku)->first();
    }
}
