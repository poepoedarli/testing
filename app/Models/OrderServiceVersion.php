<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrderServiceVersion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'order_service_version';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone('Asia/Singapore')
            ->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone('Asia/Singapore')
            ->toDateTimeString();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceVersion()
    {
        return $this->belongsTo(ApplicationVersion::class, 'service_version_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
