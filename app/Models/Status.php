<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendees;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'description'];

}
