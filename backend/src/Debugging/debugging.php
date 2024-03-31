<?php
global $router;
//$router->printRoutes();
?>

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

