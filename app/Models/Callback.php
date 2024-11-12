<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Checkin
 *
 * @property int $id
 * @property string $transaction_id
 * @property string $url
 *
 * @method int getKey()
 */
class Callback extends Model
{
    /** @use HasFactory<\Database\Factories\CallbackFactory> */
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'url'
    ];
}
