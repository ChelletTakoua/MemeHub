<?php

require_once 'src/Database/DatabaseConnection.php';

define('ENVIRONMENT', (in_array('--dev', $argv)) ? 'development' : 'production');
// TODO: maybe change sth in the config file


try {
    $db = Database\DatabaseConnection::getInstance();
} catch (PDOException $e) {
    echo ( "\033[31mDatabase connection error: " . $e->getMessage() . "\033[0m\n");
    echo ( "\033[33mCheck your database configuration in src/config/database.php\033[0m\n");
    die();

}
echo "\nDatabase connection successful.\n\n";


if (ENVIRONMENT === 'development') {
    echo "Development mode enabled. Debugging features are enabled.\n";
} else {
    echo "Production mode enabled. Debugging features are disabled.\n";
}









$appConfig = include __DIR__ . '/src/config/app.php';
$host = $appConfig['host'];
$port = $appConfig['port'];

$loadingSymbols = ['-', '\\', '|', '/'];
for ($i = 0; $i < 10; $i++) {
    echo "\rS   tarting PHP server " . $loadingSymbols[$i % 4] . "  ";
    usleep(250000);
}




echo "\033[2K\r";
exec("php -S $host:$port -t public/");




