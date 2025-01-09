<?php

namespace App\Data;

use Homeful\Products\Data\ProductData;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;

class FetchData extends Data
{

    public function __construct(
        /** @var ProductData[] */
        public ?DataCollection $products,
    ) {}
}
