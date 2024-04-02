<?php

require_once 'src/Database/DatabaseConnection.php';


/**
 * Updates the development mode in the config file.
 *
 * @param array $argv The command line arguments.
 * @return void

 */
function updateDevMode($argv)
{
    $configFile = __DIR__ . '/src/config/app.php';
    $config = include $configFile;

    $devIndex = array_search('--dev=true', $argv);
    if ($devIndex !== false) {
        $config['development_mode'] = true;
        file_put_contents($configFile, '<?php return ' . var_export($config, true) . ';');
        return;
    }

    $devIndex = array_search('--dev=false', $argv);
    if ($devIndex !== false) {
        $config['development_mode'] = false;
        file_put_contents($configFile, '<?php return ' . var_export($config, true) . ';');
    }
}

/**
 * Connects to the database.
 *
 * @return void
 */
function connectToDatabase(){
        try {
        $db = Database\DatabaseConnection::getInstance();
    } catch (PDOException $e) {
        echo ( "\033[31mDatabase connection error: " . $e->getMessage() . "\033[0m\n");
        echo ( "\033[33mCheck your database configuration in src/config/database.php\033[0m\n");
        die();

    }
    echo "\nDatabase connection successful.\n\n";
}



connectToDatabase();
updateDevMode($argv);


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




