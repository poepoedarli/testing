<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DatasetTemplate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'dataset_templates';

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

    public function application(){
        return $this->belongsTo(Application::class, 'application_id');
    }
    
    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
}
