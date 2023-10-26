<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DcaMaResult extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'dca_ma_results';

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

    public function reference()
    {
        return $this->belongsTo(DcaMaReference::class, 'ref_id');
    }
    
}