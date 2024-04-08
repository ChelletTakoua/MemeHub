<?php

require_once 'src/Database/DatabaseConnection.php';



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


function connectToDatabase(){
        try {
        $db = Database\DatabaseConnection::getInstance();
    } catch (PDOException $e) {
        echo ( "\033[31mDatabase connection error: " . $e->getMessage() . "\033[0m\n");
        echo ( "\033[33mCheck your database configuration in src/config/database.php\033[0m\n");
        die();

    }
    echo "\nDatabase connection successful.\n";
}



connectToDatabase();
updateDevMode($argv);


$appConfig = include __DIR__ . '/src/config/app.php';
$host = $appConfig['host'];
$port = $appConfig['port'];
$development_mode = $appConfig['development_mode'];


if($development_mode) {
    echo "\033[32m\nDevelopment mode enabled.\033[0m\n\n";
}else{
    echo "\033[33m\nDevelopment mode disabled.\033[0m\n\n";
}


$loadingSymbols = ['-', '\\', '|', '/'];
for ($i = 0; $i < 10; $i++) {
    echo "\rS   tarting PHP server " . $loadingSymbols[$i % 4] . "  ";
    usleep(250000);
}
echo "\033[2K\r";


exec("php -S $host:$port -t public/");




