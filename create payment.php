<?php

$data = [
    "merchant_id" => "xxxx-xxx-xxxxxxxxxxxx-xxxxxxxxxx",
    "amount" => 500000, //// rial
    "invoice_id" => "PF-123456",
    "description" => "Invoice Description",
    "name" => "Ali Ahmadi",
    "mobile" => "09120001234",
    "email" => "info@example.com",
    "callback_url" => "https://YourSite.com/Callback"
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.novinopay.com/payment/ipg/v2/request");
curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type" => "application/json"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
curl_setopt($curl, CURLOPT_TIMEOUT, 50);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_exec = curl_exec($curl);
curl_close($curl);

$result = json_decode($curl_exec);

if (isset($result->status) && $result->status == 100) {
    ///save $result->data->authority in db
    ///save $result->data->trans_id in db

    header("Location: {$result->data->payment_url}");
} else {
    echo isset($result->status) ? "Error Code: {$result->status} | {$result->message}" : "Error Connecting to novinopay.com";
}