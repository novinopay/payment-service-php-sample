<?php

$data = [
    "merchant_id" => "xxxx-xxx-xxxxxxxxxxxx-xxxxxxxxxx",
    "authority" => "812F739E41057BAC22331918CD5B41C2a"
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.novinopay.com/payment/ipg/v2/inquiry");
curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type" => "application/json"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
curl_setopt($curl, CURLOPT_TIMEOUT, 50);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_exec = curl_exec($curl);
curl_close($curl);

$result = json_decode($curl_exec);

if (isset($result->status) && isset($result->message)) {
    echo "status: {$result->status} | message: {$result->message}" . PHP_EOL;

    if (isset($result->data)){
        $ref_id = $result->data->ref_id ?? null;
        $card_pan = $result->data->card_pan ?? null;
        echo "trans_id: {$result->data->trans_id} | ref_id: {$ref_id} | card_pan: {$card_pan}";
    }
} else {
    echo isset($result->status) ? "Error Code: {$result->status} | {$result->message}" : "Error Connecting to novinopay.com";
}
