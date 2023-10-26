<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataSetTraining extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'data_set_training';
    
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

    public function serviceVersion()
    {
        return $this->belongsTo(ApplicationVersion::class, 'service_version_id');
    }
}
