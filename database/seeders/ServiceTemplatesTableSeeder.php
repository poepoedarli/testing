<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ServiceTemplatesTableSeeder extends Seeder
{
    public function run(): void
    {
        // adc
        $adc_service = Service::where('name', 'adc')->first();
        if($adc_service){
            $service_templates = [
                [
                    'service_id' => $adc_service->id,
                    'name' => 'Manual Adjustment',
                    'uri' => 'adc/manual_adjustment',
                ],
                [
                    'service_id' => $adc_service->id,
                    'name' => 'Report',
                    'uri' => 'adc/report',
                ]
            ];
            foreach ($service_templates as $service_template) {
               ServiceTemplate::create($service_template);
            }
        }
    }
}
