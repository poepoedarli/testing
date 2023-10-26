<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Application extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'applications';

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

    public function application_creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function dataset_template()
    {
        return $this->hasOne(DatasetTemplate::class, 'application_id', 'id');
    }

    public function operation_pages()
    {
        return $this->hasMany(OperationPage::class, 'application_id');
    }

    public function operation_page($route_name)
    {
        return $this->operation_pages()->where('route_name', '=', $route_name)->first();
    }

    public function parent_pages()
    {
        return $this->operation_pages()->where('parent_id', '=', null);
    }

    public function resource_usages()
    {
        return $this->hasOne(ApplicationResourcesUsage::class, 'application_id', 'id');
    }
}
