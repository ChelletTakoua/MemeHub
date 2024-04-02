<?php
    header('Content-Type: text/html; charset=utf-8');
    

    $index = $_GET["index"]-1;

    $request = $_SESSION["requests"][$index];
    $currentRoute = $request["routing"]["matched_route"];
    $routes = $request["routing"]["matching_logs"];
    $actualPath = $request["request"]["url"];
?>

<!DOCTYPE html>
<html lang="">
<head>
    <title> Request <?= $index ?> Details </title>
    <link href="../index.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Routes :</h2>
    <div class="route-info">
        <h4 class="path-box">

            <span class='underline-text'> Matched Route :</span>
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