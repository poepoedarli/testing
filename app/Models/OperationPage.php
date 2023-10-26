<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationPage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'operation_pages';
    public $timestamps = false;

    
    public function operation(){
        return $this->belongsTo(Applications::class, 'application_id');
    }

    public function children(){
        return $this->hasMany(OperationPage::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(OperationPage::class, 'parent_id');
    }

    
    public function child($route_name){
        return $this->children()->where('route_name', '=', $route_name)->first();
    }
}
