<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Callback;

class CreateCallback
{
    use AsAction;

    public function handle(string $transaction_id, string $url)
    {
        $callback = Callback::create(compact('transaction_id', 'url'));

        return $callback->id;
    }
}
