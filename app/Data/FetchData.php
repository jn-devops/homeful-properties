<?php

namespace App\Data;

use Homeful\Properties\Data\ProjectData;
use Homeful\Products\Data\ProductData;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Data;

class FetchData extends Data
{
    public function __construct(
        /** @var ProductData[] */
        public ?DataCollection $products,
        /** @var ProjectData[] */
        public ?DataCollection $projects,
    ) {}
}
