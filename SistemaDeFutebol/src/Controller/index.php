<?php


function ApiController()
{
    $url = "https://api.football-data.org/v4/competitions/2021/matches";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Auth-Token: 6513aa7e22144ca28200b320473477d0"
    ));
    $res = json_decode(curl_exec($ch), true);

    return $res["matches"];

}
