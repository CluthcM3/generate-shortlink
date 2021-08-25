<?php

function jmdev()
{

    $ch = curl_init('https://url.jmdev.ca/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// get headers too with this line
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $result = curl_exec($ch);
// get cookie
// multi-cookie variant contributed by @Combuster in comments
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    $cookies = array();
    foreach($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }
    $a = $cookies['urlshortner_session'] . PHP_EOL;
    $b = $cookies['XSRF-TOKEN'] . PHP_EOL;




    $url = "https://url.jmdev.ca/api";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Connection: keep-alive",
        "sec-ch-ua: \"Chromium\";v=\"92\", \" Not A;Brand\";v=\"99\", \"Google Chrome\";v=\"92\"",
        "Accept: */*",
        "X-Requested-With: XMLHttpRequest",
        "sec-ch-ua-mobile: ?0",
        "User-Agent: Mozilla/5.0 (Linux; Android 11; SM-A505FN) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.115 Mobile Safari/537.36",
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "Origin: https://url.jmdev.ca",
        "Sec-Fetch-Site: same-origin",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Dest: empty",
        "Referer: https://url.jmdev.ca/",
        "Accept-Language: en-US,en;q=0.9",
        "Cookie: __gads=ID=e6d259db318a2b79-2219d9b01ecb0025:T=1629889779:RT=1629889779:S=ALNI_MYlC6WgMndvii_WWFBXQGbhlt_dTw;  XSRF-TOKEN=".$cookies['XSRF-TOKEN']."; urlshortner_session=".$cookies['urlshortner_session'],
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = "url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3Dlb8sawAdD9E";

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $plier = json_decode($resp,1);


    if ($plier['error'] === true)
    {
        echo $plier['message'] . PHP_EOL;
        sleep(1);
        exit();
    } else
    {

        echo $plier['message'] . file_put_contents('a.txt',$plier['href'] . PHP_EOL,FILE_APPEND) . PHP_EOL;

    }

}

for ($i=0;$i<=5;$i++)
{
    jmdev();
    sleep(30);
}