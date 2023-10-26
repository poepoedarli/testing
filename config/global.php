<?php
   
return [
    'log_types'=> [
        'info', 'warning', 'error', 'alert', 'debug'
    ],

    'dataset_types'=> [
        'Structured Datasets', 'Text Datasets', 'Image Datasets', 'Audio Datasets', 'Time Series Datasets'
    ],

    'FILE_SERVER_DOMAIN' =>  'https://wavelengthblob.file.core.windows.net/',
    'FILE_SERVER_SECRET_KEY' =>  '?sv=2022-11-02&st=2023-08-16T07%3A40%3A45Z&se=2024-08-17T07%3A40%3A00Z&sr=s&sp=rl&sig=bxUw7R9IYysOnDNYY%2Bak9pCTIB4qY1iNuMfBVHqVxUM%3D',

    'AZURE_STORAGE_URL' => env('AZURE_STORAGE_URL'),
    'AZURE_BLOB_DATASET_SAS' => env('AZURE_BLOB_DATASET_SAS'),

    'app_not_found' => 'Application Not Found!',
]
  
?>