<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\OperationPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AdcPcbOperationPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // application adc-pcb
        $application = Application::find(1);

        if (!is_null($application)) {
            // pages
            $tasks_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'adc_pcb.tasks',
                'title' => 'Tasks',
            ]);

            $new_task_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'adc_pcb.new_task',
                'title' => 'New Task',
                'parent_id' => $tasks_page->id,
            ]);

            $manual_labelling_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'adc_pcb.manual_labelling',
                'title' => 'Manual Labelling',
                'parent_id' => $tasks_page->id,
                'parameters' => json_encode(['task_id', 'result_id'])
            ]);

            $reports_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'adc_pcb.report',
                'title' => 'Report',
                'parent_id' => $tasks_page->id,
                'parameters' => json_encode(['task_id'])
            ]);

        }
    }
}