<?php

function ApiController()
{

    $url = "https://api.football-data.org/v4/competitions/2021/matches";
    $token = getenv('API_TOKEN') ?: ($_ENV['API_TOKEN'] ?? false);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Auth-Token: $token"
    ));
    $res = json_decode(curl_exec($ch), true);

    return $res["matches"];

}
