<?php

namespace App\Models\Custom;

use App\Models\ApplicationTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DcaMaReference extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'dca_ma_references';
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

    public function results()
    {
        return $this->hasMany(DcaMaResult::class, 'ref_id', 'id');
    }

    public function tpNum()
    {
        return $this->results->where('ai_result', 'G')->where('label_result', 'G')->count();
    }
    public function fpNum()
    {
        return $this->results->where('ai_result', 'G')->where('label_result', 'NG')->count();
    }
    public function tnNum()
    {
        return $this->results->where('ai_result', 'NG')->where('label_result', 'G')->count();
    }
    public function fnNum()
    {
        return $this->results->where('ai_result', 'NG')->where('label_result', 'NG')->count();
    }


    public function task()
    {
        return $this->belongsTo(ApplicationTask::class, 'task_id');
    }
}