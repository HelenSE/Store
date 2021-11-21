<?php
//$connection = new mysqli('localhost', 'root', '', 'mvc');
//if (mysqli_connect_error()){
//    echo "NO DB CONNECTION";
//    die();
//}
function render($template = '', $vars = []){
    foreach ($vars as $varName => $varValue){
        ${$varName} = $varValue;
    }
    $path = __DIR__."/../views/".$template;
    if (file_exists($path) && is_file($path)){
        include $path;
    }
    else {
        echo "VIEW NOT FOUND";
    }
}
