<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\OperationPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationOperationPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // application dca-ma
        $application = Application::find(2);
        if (!is_null($application)) {
            // pages
            $tasks_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'dca_ma.tasks',
                'title' => 'Tasks',
            ]);

            $new_task_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'dca_ma.new_task',
                'title' => 'New Task',
                'parent_id' => $tasks_page->id,
            ]);

            $manual_labelling_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'dca_ma.manual_labelling',
                'title' => 'Manual Labelling',
                'parent_id' => $tasks_page->id,
                'parameters' => json_encode([ 'task_id', 'result_id'])
            ]);
            
            $reports_page = OperationPage::create([
                'application_id' => $application->id,
                'route_name' => 'dca_ma.report',
                'title' => 'Report',
                'parent_id' => $tasks_page->id,
                'parameters' => json_encode(['task_id'])
            ]);
            
        }
    }
}