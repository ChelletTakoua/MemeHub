<?php
    header('Content-Type: text/html; charset=utf-8');
    include 'response_code.php';

    $index = $_GET["index"]-1;

    $request = $_SESSION["requests"][$index];
    // request and response stored in the session :
    $response = $request["response"];
    $query = $request["request"];

    // routing logs :
    $currentRoute = $request["routing"]["matched_route"];
    $routes = $request["routing"]["matching_logs"];
    $actualPath = $request["request"]["url"];
    if(str_contains($actualPath, "?")){
        $actualPath = substr($actualPath,0,strpos($actualPath,"?"));
    }
?>

<!DOCTYPE html>
<html lang="">
<head>
    <title> Request <?= $index ?> Details </title>
    <link href="../index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

<?php
    //-----------------Request-----------------
    $query["body"] = json_encode(json_decode($query["body"]), JSON_PRETTY_PRINT);

?>
    <div class="backArrow backArrowContainer">
        <a href="/admin/sessionHistory">
            <i class="fas fa-arrow-left backArrow"></i>
        </a>
    </div>
<div class="container">
    <h1 class="underline-text">Request :</h1>
<div class="table-container">
    <div class="info-container">

        <div class="left-info">
                <h4 class="path-box"><span class='underline-text'>Method:</span> <span class='method'><?= $query["method"] ?> </span></h4>
                <h4 class="path-box"><span class="underline-text">URL:</span> <span class="path text-gray"><?= $query["url"] ?></span></h4>
        </div>
        <div class="right-info">
            <h4 class="right-info path-box status-text"><?= displayResponseCode($response["status_code"]) ?></h4>
            <h4 class="right-info path-box path timestamp"><?= date('Y-m-d H:i:s', floor($response["timestamp"])) ?></h4>
        </div>

    </div>


</div>
        <?php
            if(!empty($response["error_message"])){
                echo("<div class='inline-box-error parent-container'>");
                echo("<span class='error underline-text'>Error message :</span>");
                echo("<h5 class='error-message path-box'>".$response["error_message"]."</h5>");
                echo("</div>");
            }
        ?>

    <?php
        //create a table for every method (Get/ Post) and display the parameters
    ?>
    <h2>GET Parameters :</h2>
    <div class="table-container">
        <table border="1">
            <tr class="table-head ">
                <th>Parameter</th>
                <th class='value-cell '>Value</th>
            </tr>
            <?php foreach ($query["get_params"] as $key => $value): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td class='value-cell'><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <h2>POST Parameters :</h2>
    <div class="table-container">
        <table border="1">
            <tr class="table-head ">
                <th>Parameter</th>
                <th class='value-cell '>Value</th>
            </tr>
            <?php foreach ($query["post_params"] as $key => $value): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td class='value-cell'><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>


    <h2>Request Headers :</h2>
    <div class="table-container">
        <table border="1">
            <tr class="table-head">
                <th>Header</th>
                <th>Value</th>
            </tr>
            <?php
            foreach ($query["headers"] as $key => $value) {
                echo("<tr> <td>" . $key . "</td> <td>" . $value . "</td> </tr>");
            }
            ?>
        </table>
    </div>
    <h2>Request Body :</h2>
    <div class="body-container inline-box">
        <pre><?= $query["body"] ?></pre>
    </div>

    <?php
        //-----------------Response-----------------
        $response["body"] = json_encode($response["body"], JSON_PRETTY_PRINT);
    ?>
</div>
<div class="container">

    <h1 class="underline-text">Response :</h1>
    <h2>Response Headers :</h2>
    <div class="table-container">
        <table border="1">
            <tr class="table-head">
                <th>Header</th>
                <th>Value</th>
            </tr>
            <?php
            foreach ($response["headers"] as $key => $value) {
                echo("<tr> <td>" . $key . "</td> <td>" . $value . "</td> </tr>");
            }
            ?>
        </table>
    </div>
    <h2>Response Body :</h2>
    <div class="body-container inline-box">
        <pre><?= $response["body"] ?></pre>
    </div>

</div>
<div class="container">

    <!-----------------Matching Routes----------------->

    <h1 class="underline-text">Routes :</h1>
    <div class="route-info">
        <h4 class="path-box">

            <span class='underline-text'> Active Path :</span>
            <?php
            if(empty($currentRoute)){
                echo("<span class='path text-gray'>No route found</span>");
            }else{
                echo("<span class='path text-gray'>" .$actualPath . "</span>");
            }

            ?>
        </h4>
    </div>
    <h2>Route Parameters :</h2>
    <div class="table-container">
        <table border="1">
            <tr class="table-head">
                <th>Parameter</th>
                <th class='value-cell'>Value</th>
            </tr>
            <?php
            if(!empty($currentRoute["matches"])) {
                if (!empty($currentRoute)) {
                    foreach ($currentRoute["matches"] as $key => $value) {
                        echo("<tr> <td>" . $key . "</td> <td class='value-cell'>" . $value . "</td> </tr>");
                    }
                }
            }
            ?>
        </table>
    </div>

    <h2>Routes Matching Logs :</h2>

    <div class="table-container">
        <h4 class="path-box"> <span class="underline-text">Path to match :</span>   <span class="path text-gray"><?php echo ($currentRoute["path"]);?></span> </h4>
        <table border="1">
            <tr class="table-head">
                <th>#</th>
                <th>Method</th>
                <th>Callable</th>
                <th>Path</th>
                <th>Matching Status</th>
            </tr>
            <?php
            $counter = 0;
            foreach ($routes as $route){
                $counter++;
                if($route["matchingStatus"] == "matched")
                    $status = "matched";
                else if($route["matchingStatus"] == "not matched")
                    $status = "not-matched";
                else
                    $status = "not-checked";

                $closure = "";
                if( $route["callable"]=="Closure" ){
                    $closure = "closure";
                }

                echo("<tr> <td>".$counter."</td> <td class='method'>".$request["request"]["method"]."</td> <td class='".$closure."'>".str_replace("@","<span class='callable '>@</span>",$route["callable"])."</td> <td class ='path'>".$route["path"]."</td> <td class=".$status.">".$route["matchingStatus"]."</td> </tr>");
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>