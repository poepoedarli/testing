<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTemplate extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'service_templates';
    use HasFactory;

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
}
