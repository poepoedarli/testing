<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ServicesTableSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'ADC',
                'icon' => 'adc.jpg',
                'version' => "1.0",
                'description' => 'Automatic Defect Classification that classifies defects based on image and metadata such as location, ROI, and other information associated with a defect. ADC is a machine learning and computer vision technique used in various industries, particularly manufacturing, to automatically identify and categorize defects or anomalies in products or processes. It plays a crucial role in quality control and inspection processes by reducing human error and increasing the efficiency and accuracy of defect detection and classification.',
                'creator_id' => User::find(1)->id,
                'status' => true,
            ],  
            [
                'name' => 'OCR',
                'icon' => 'ocr.jpg',
                'version' => "1.0",
                'description' => 'Cognex Deep Learning tools enable manufacturers to accurately read identification codes on wafer carrier rings, even after they have degraded from multiple cleanings. A smart camera and deep learning software work together to decipher damaged codes using optical character recognition (OCR).',
                'creator_id' => User::find(1)->id,
                'status' => true,
            ],
            [
                'name' => 'CDSEM',
                'icon' => 'cdsem.jpg',
                'version' => "1.0",
                'description' => 'A Critical Dimension SEM (CD-SEM: Critical Dimension Scanning Electron Microscope) is a dedicated system for measuring the dimensions of the fine patterns formed on a semiconductor wafer. CD-SEM is mainly used in the manufacturing lines of electronic devices of semiconductors.',
                'creator_id' => User::find(1)->id,
                'status' => true,
            ],
            [
                'name' => 'RECC',
                'icon' => 'recc.png',
                'version' => "1.0",
                'description' => 'A remote access management platform, is a technology solution that allows organizations to manage and control access to their computer systems, networks, and devices from a remote location.',
                'creator_id' => User::find(1)->id,
                'status' => true,
            ],
        ];

        foreach ($services as $service) {
            $service = Service::create($service);
        }
    }
}
