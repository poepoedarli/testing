<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'order';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderServiceVersion()
    {
        return $this->hasMany(OrderServiceVersion::class, 'order_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone('Asia/Singapore')
            ->toDateTimeString();
    }

    public function getPayTimeAttribute($value)
    {
        if ($value) {
            return Carbon::createFromTimestamp(strtotime($value))
                ->timezone('Asia/Singapore')
                ->toDateTimeString();
        }

    }
}
