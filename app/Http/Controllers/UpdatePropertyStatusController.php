<?php

namespace App\Http\Controllers;

use App\Models\Callback;
use App\Models\Status;
use Homeful\Properties\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Actions\UpdatePropertyStatus;

class UpdatePropertyStatusController extends Controller
{
    public function __invoke(Request $request, string $property_code, string $status, string $transaction_id): \Illuminate\Http\RedirectResponse
    {
        $status = Status::where('code', $status)->firstOrFail();
        $property = Property::where('code', $property_code)->firstOrFail();
        UpdatePropertyStatus::run($property, $status);
        $callback = Callback::where('transaction_id',  $transaction_id)->firstOrFail();

        return redirect()->away($callback);
    }
}
