<?php

namespace App\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Homeful\Properties\Models\Property;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\Callback;
use App\Models\Status;

class UpdatePropertyStatus
{
    use AsAction;

    public function handle(Property $property, Status $status): void
    {
        $property->status = $status->code;
        $property->save();
    }
}
