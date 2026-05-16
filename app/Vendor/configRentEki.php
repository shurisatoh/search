<?php

function ensenArr() {
    $json = file_get_contents(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'trains.json');
    $trains = json_decode($json, true);

    $arr = [];

    foreach ($trains as $station) {
        $linecode = strval($station['linecode']); // ← 数値でなく文字列で扱う
        $linename = $station['linename_en'];

        if (!isset($arr[$linecode])) {
            $arr[$linecode] = $linename;
        }
    }

    return $arr;
}

function ekiArr() {
    $json = file_get_contents(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'trains.json');
    $trains = json_decode($json, true);

    $arr = [];

    foreach ($trains as $station) {
        $linecode = strval($station['linecode']);        // ← 文字列で扱う
        $stationcode = strval($station['stationcode']);  // ← 文字列で扱う
        $stationname = $station['stationname_en'];

        if (!isset($arr[$linecode])) {
            $arr[$linecode] = [];
        }

        $arr[$linecode][$stationcode] = $stationname;
    }

    return $arr;
}

