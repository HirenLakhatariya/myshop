<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('codeLog')) {
    function codeLog($data, $filename = 'local') {
        $logPath = storage_path("logs/{$filename}.log");
        $logData = "[" . now() . "] " . print_r($data, true) . "\n";
        
        file_put_contents($logPath, $logData, FILE_APPEND);
    }
}
