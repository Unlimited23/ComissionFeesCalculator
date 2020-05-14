<?php

// Autoloading with Composer
require __DIR__ . '/vendor/autoload.php';

try {
    // Calculator instance
    $cfc = new \App\CFCalculator();
    // File Service instance
    $fs = new App\Services\FileService();
    // Commission fees
    if (!empty($cfc->getConfig())) {
        // Does all
        $res = $cfc->init();
        // Prints to STDOUT
        $fs::printToStdout($res);
    }
} catch (\Exception $e) {
    echo $e->getTraceAsString() . PHP_EOL;
}
