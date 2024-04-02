<?php
header('Content-Type: text/html; charset=utf-8');
global $router;
$requests = $_SESSION['requests'];
$index = 1;

?>
<!DOCTYPE html>
<html lang="">
<head>
    <title>Debugging</title>
    <link href="../index.css" rel="stylesheet">
</head>
<body>
<h1>Routes</h1>
<table border='1'>
    <tr>
        <th>Method</th>
        <th>Path</th>
        <th>Callable</th>
        <th>Roles</th>
    </tr>

    <?php foreach ($router->routes as $method => $routes): ?>
        <?php foreach ($routes as $route): ?>
            <tr>
                <td><?= $method ?></td>
                <td><?= $route->getPath() ?></td>
                <td><?= $route->getCallable() ?></td>
                <td><?= implode(", ", $route->getRoles()) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>


<!-- historique -->
<h1>Historique</h1>
<table border='1'>
    <tr>
        <th>Index</th>
        <th>Method</th>
        <th>Url</th>
        <th>Date</th>
        <th>Status code</th>
        <th> </th>
    </tr>

    <?php foreach ($requests as $rq): ?>
        
            <tr>
                <td><?= $index ++ ?></td>
                <td><?= $rq['request']['method'] ?></td>
                <td><?= $rq['request']['url'] ?></td>
                <td><?= $rq['request']['timestamp'] ?></td>
                <td><?= $rq['response']['status_code'] ?></td>
                <td>
                <?php
// Assuming $index is already set to the desired value
echo "<a href='/admin/requestDetails?index=" . $index . "'><button>Details</button></a>";
?>
                </td>
            </tr>
        
    <?php endforeach; ?>
</table>
</body>
</html>