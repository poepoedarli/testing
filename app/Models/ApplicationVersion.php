<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApplicationVersion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'application_version';

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

    public function service()
    {
        return $this->belongsTo(Application::class, 'service_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(ApplicationSubscriptions::class,"application_id");
    }
}
