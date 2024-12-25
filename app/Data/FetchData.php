<?php

namespace App\Data;

use Homeful\Properties\Data\PropertyData;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;

class FetchData extends Data
{

    public function __construct(
        /** @var PropertyData[] */
        public ?DataCollection $properties,
    ) {}
}
