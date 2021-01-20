<?php

function sp(){
    echo " ";
}


function print_module_data($jdata) {
    $start = explode(":", explode(" ", $jdata["start"])[1]);
    $date  = explode("-", explode(" ", $jdata["start"])[0]);
    echo "Le\e[94m ", $date[2], "/", $date[1], " \e[39mde\e[94m ",  $start[0], "h", $start[1], "\e[39m à ";
    $end = explode(":", explode(" ", $jdata["end"])[1]);
    echo "\e[96m",  $end[0], "h", $end[1], "\e[39m ";
    echo ($jdata["event_registered"]) ? "\e[32mregistered  \e[39m" : "\033[01;31mno register \e[39m";
    echo explode(" ", $jdata["titlemodule"])[2];
    sp();
    echo "\e[37m", $jdata["acti_title"], "\e[39m ";
    echo "\n";
}

$intra_autolog = file_get_contents("./Credentials");

$start = date("Y-m-d", strtotime("now"));
$tmp = strtotime("+7 day", strtotime("now"));
$end = date("Y-m-d", $tmp);

$cucu = curl_init("https://intra.epitech.eu/$intra_autolog/planning/load?format=json&start=$start&end=$end");
curl_setopt($cucu, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($cucu);

$array = json_decode($output, null, 512, JSON_OBJECT_AS_ARRAY);
$my_code = json_decode(file_get_contents("./config.json"), null, 512, JSON_OBJECT_AS_ARRAY);

foreach ($array as $tmp) {
    foreach($my_code["module"] as $code) {
        if ($tmp["codemodule"] == $code)
            print_module_data($tmp);
    }
}

?>