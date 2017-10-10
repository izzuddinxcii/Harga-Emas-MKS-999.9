<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://live.mks.ch/mobile/myr/v1/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode != '200'){
    echo 'Bad Data';
    echo '<br>';
} else {
    preg_match_all('/class=\"date\">(.*)<\/font>/', $response, $datematch);
    preg_match_all('/right\">(.*)<\/td>/', $response, $datamatch);
    
    $curlDate = (string)str_replace(' CET           ', '', $datematch[1][0]);
    
    $dateGold = new DateTime($curlDate, new DateTimeZone('Europe/Andorra'));
    $dateGold->setTimezone(new DateTimeZone('Asia/Kuala_Lumpur'));
    $dateGold = $dateGold->format('d-m-Y H:i:s');
    
    $priceGold = number_format(((float)str_replace(' ', '', $datamatch[1][4]))*0.001, 2, '.', '');
    $priceGoldSell = number_format(((float)str_replace(' ', '', $datamatch[1][3]))*0.001, 2, '.', '');
    
    echo 'Last Update '. $dateGold;
    echo '<br>';
    echo 'Sell Price RM'. $priceGold;
    echo '<br>';
    echo 'Buy Price RM'. $priceGoldSell;
}
