<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Homeful\Products\Data\ProductData;
use Illuminate\Http\Request;

class ProductResource extends JsonResource
{

    protected ProductData $data;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->data = ProductData::fromModel($resource);
    }

    public function toArray(Request $request): array
    {
        return $this->data->toArray();
    }

    public function with(Request $request): array
    {
        return [
            'json' => $this->data->toJson()
        ];
    }
}
