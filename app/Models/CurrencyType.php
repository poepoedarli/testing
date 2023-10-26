<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CurrencyType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'currency_type';
}
