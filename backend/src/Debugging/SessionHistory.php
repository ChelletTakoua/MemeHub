<?php
header('Content-Type: text/html; charset=utf-8');
include 'response_code.php';

global $router;
$requests = $_SESSION['requests'];
$index = 0;

?>
<!DOCTYPE html>
<html lang="">
<head>
    <title>Debugging</title>
    <link href="../index.css" rel="stylesheet">
</head>
<body>
<div class="container">

<h2>Routes :</h2>
<div class="table-container">

<table border='1'>
<tr class="table-head">
        <th>Method</th>
        <th>Path</th>
        <th>Callable</th>
        <th>Roles</th>
    </tr>

    <?php foreach ($router->routes as $method => $routes): ?>
        <?php foreach ($routes as $route): ?>
            <tr>
                <td class ="method"><?= $method ?></td>
                <td class="path"><?= $route->getPath() ?></td>
                <td><?php 
                if($route->getCallable()=="Closure") {
                    echo(str_replace("Closure", "<span class='closure'>Closure</span>", $route->getCallable()));
                }
                    else{
                        echo(str_replace("@", "<span class='callable'>@</span>", $route->getCallable()));
                     } ?></td>
                <td class ="path"><?= implode(", ", $route->getRoles()) . ($route->developmentMode?" <span class='devMode'>(dev)</span>":"") ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>
</div>
</div>
<div class="container">
<!-- historique -->
<h2>History :</h2>
<div class="table-container">

<table border='1'>
<tr class="table-head">
        <th>#</th>
        <th>Method</th>
        <th>Path</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status code</th>
        <th> </th>
    </tr>

    <?php  $totalRequests = count($requests);
    foreach ($requests as $index => $rq): 
        // Skip the last iteration
        if ($index === $totalRequests - 1) {
            continue;
        }
    ?>
        
        <tr >
                <td><?= ++$index ?></td>
                <td class ="method"><?= $rq['request']['method'] ?></td>
                <td class ="path"><?= $rq['request']['url'] ?></td>
                <td class ="path"><?php

                        $timestamp = $rq['request']['timestamp'];
                        $date = date('Y-m-d H:i:s',floor($timestamp));
                        echo $date;
                        ?>
                </td>
                <td class ="ms"><?php

                        $timestamp1 = $rq['request']['timestamp'];
                        $timestamp2= $rq['response']['timestamp'];
                        $time = floor(($timestamp2 - $timestamp1)*1000);
                        echo $time;
                        ?> ms</td>
                <td class ="path"><?= displayResponseCode($rq['response']['status_code']) ?></td>
                <td class = "path">
                <?php

                    echo "<a href='/admin/requestDetails?index=" . $index . "'><button>Details</button></a>";
                ?>
                </td>
            </tr>
        
    <?php endforeach; ?>
</table>
</div>
</div>
</body>
</html>