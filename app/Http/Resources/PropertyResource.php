<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Homeful\Properties\Data\PropertyData;
use Homeful\Properties\Models\Property;
use Illuminate\Http\Request;

class PropertyResource extends JsonResource
{

    protected PropertyData $data;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->data = PropertyData::fromModel($resource);
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
