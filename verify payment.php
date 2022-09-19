<?php

if (isset($_REQUEST["PaymentStatus"]) && $_REQUEST["PaymentStatus"] == "OK") {

    $Authority = (isset($_REQUEST["Authority"]) && !empty($_REQUEST["Authority"])) ? $_REQUEST["Authority"] : "";
    $InvoiceID = (isset($_REQUEST["InvoiceID"]) &&  !empty($_REQUEST["InvoiceID"])) ? $_REQUEST["InvoiceID"] : "";

    $amount = 1000000; /// Get From DB

    $data = [
        "merchant_id" => "xxxx-xxx-xxxxxxxxxxxx-xxxxxxxxxx",
        "amount" => (int) $amount,
        "authority" => $Authority
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.novinopay.com/payment/ipg/v2/verification");
    curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type" => "application/json"]);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_exec = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($curl_exec);

    if (isset($result->status) && $result->status == 100) {
        echo "Invoice Successfully Paid | Price: {$result->data->amount} Rial | RefID: {$result->data->ref_id}";
    } else {
        echo isset($result->status) ? "Error Code: {$result->status} | {$result->message}" : "Error Connecting to novinopay.com";
    }

}else{
    echo 'Your Payment is failed';
}
