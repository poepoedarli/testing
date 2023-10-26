<?php

namespace App\Services;
use App\Models\AuditLog;
use App\Services\Common;
use Exception;
class Logger
{
    protected $common;

    public function __construct(Common $common)
    {
        $this->common = $common;
    }

    public function createLog($title, $message, $type, $tbl_name = null, $id = 0, $data= null)
    {
        try {
            if(!in_array($type, config('global.log_types'))){
                $type = 'info';
            }
            AuditLog::create([
                'title'=> $title,
                'message'=> $message,
                'type'=> $type,
                'ip_address' => $this->common->getIp(),
                'user_id'=> Auth()->user()->id,
                'table_name' => $tbl_name,
                'table_id' => $id,
                'data'=> json_encode($data),
            ]);
        } catch (Exception $ex) {
            AuditLog::create([
                'title'=> 'Qeuery Error',
                'message'=> json_encode($ex),
                'type'=> 'error',
                'ip_address' => $this->common->getIp(),
                'user_id'=> Auth()->user()->id,
            ]);
        }

        return true;
    }
}
