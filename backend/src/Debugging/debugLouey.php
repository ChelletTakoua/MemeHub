<?php
    header('Content-Type: text/html; charset=utf-8');

    function displayResponseCode($code)
    {
        $class = '';
        $error="";
        if ($code >= 200 && $code < 300) {
            $class = 'success';
            $error="OK";
        } elseif ($code >= 300 && $code < 400) {
            $class = 'redirection';
            $error="Redirection";
        } elseif ($code >= 400 && $code < 500) {
            $class = 'client-error';
            $error="Client Error";
        } elseif ($code >= 500 && $code < 600) {
            $class = 'server-error';
            $error="Server Error";
        }
        else{
            return $code;
        }

        return "<span class='".$class."'><span class='status-point'>●</span>  ".$code."   ".$error."</span>";
    }


    $index = $_GET["index"]-1;


    $index = $_GET["index"];

    $request = $_SESSION["requests"][$index];
    // request and response stored in the session :
    $response = $request["response"];
    $query = $request["request"];

    // routing logs :
    $currentRoute = $request["routing"]["matched_route"];
    $routes = $request["routing"]["matching_logs"];
    $actualPath = $request["request"]["url"];
    if(strpos($actualPath,"?") !== false){
        $actualPath = substr($actualPath,0,strpos($actualPath,"?"));
    }
?>

<!DOCTYPE html>
<html lang="">
<head>
    <title> Request <?= $index ?> Details </title>
    <link href="../index.css" rel="stylesheet">
</head>
<body>
<?php
    //-----------------Request-----------------
    //make the request headers and body more readable
    $query["headers"] = array_change_key_case($query["headers"], CASE_LOWER);
    $query["headers"] = array_change_key_case($query["headers"], CASE_LOWER);
    $query["body"] = json_encode(json_decode($query["body"]), JSON_PRETTY_PRINT);
    $query["body"] = str_replace("\n", "<br>", $query["body"]);

    //make the url / method / status and timestamp in a box like the path box in the routes , make the status and timestamp to the right and the others to the left and make status green with an ok next to it if it's a success and red if it's an error and display the error next to it
?>
<div class="container">
    <h2>Request :</h2>
<div class="table-container">
    <div class="info-container">

        <div class="left-info">
                <h4 class="path-box"><span class='underline-text'>Method: </span><span class='method'><?= $query["method"] ?></span></h4>
                <h4 class="path-box"><span class="underline-text">URL:</span> <span class="path text-gray"><?= $query["url"] ?></span></h4>
        </div>
        <div class="right-info">
            <h4 class="right-info path-box status-text"><?= displayResponseCode($response["status_code"]) ?></h4>
            <h4 class="right-info path-box path"><?= date('Y-m-d H:i:s', $response["timestamp"]) ?></h4>
        </div>

    </div>

</div>

    <h2>Request Headers :</h2>
    <div class="table-container">
        <table border="1">
            <tr class="table-head
            ">
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
    <div class="body-container">
        <pre><?= $query["body"] ?></pre>
    </div>
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
    <div class="body-container">
        <pre><?= $response["body"] ?></pre>
    </div>


    <!-----------------Matching Routes----------------->

    <h2>Routes :</h2>
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