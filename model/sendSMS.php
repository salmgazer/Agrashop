<?php

// Let us test the SDK
if(!isset($_GET['phone'])){
    echo '{"result": 0, "message": "There was a problem try sending again"}';
    return;
}

$customer = $_GET['phone'];
$newMessage = "10% discount on your next purchase";

require 'Smsgh/Api.php';

//$auth = new BasicAuth("yralkzfn", "znbzlsho");
$auth = new BasicAuth("obxffxqt", "wmqimxzt");
// instance of ApiHost
$apiHost = new ApiHost($auth);

// instance of AccountApi
$accountApi = new AccountApi($apiHost);
// Get the account profile
// Let us try to send some message
$messagingApi = new MessagingApi($apiHost);

try {
    // Send a quick message
    //$messageResponse = $messagingApi->sendQuickMessage("Husby", "+2332432191768", "I love you dearly Honey. See you in the evening...");


    $mesg = new Message();
    $mesg->setContent($newMessage);
    $mesg->setTo($customer);
    $mesg->setFrom("+233543344100");
    $mesg->setRegisteredDelivery(true);

    // Let us say we want to send the message 3 days from today
    //$mesg->setTime(date('Y-m-d H:i:s', strtotime('+1 week')));

    $messageResponse = $messagingApi->sendMessage($mesg);

    if ($messageResponse instanceof MessageResponse) {
        echo '{"result": 1, "message": "'.$messageResponse->getStatus().'"}';
        return;
        //echo $messageResponse->getStatus();
    } elseif ($messageResponse instanceof HttpResponse) {
        echo '{"result": 0, "message": "'.$messageResponse->getStatus().'"}';
        return;
       // echo "\nServer Response Status : " . $messageResponse->getStatus();
    }
} catch (Exception $ex) {
    echo $ex->getTraceAsString();
}
