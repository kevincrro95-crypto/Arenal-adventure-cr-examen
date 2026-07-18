<?php
class Logger {
    public static function error(Throwable $error): void {
        $line = date('Y-m-d H:i:s') . ' | ' . $error->getMessage() . PHP_EOL;
        error_log($line, 3, __DIR__ . '/../../storage/logs/app.log');
    }
}
