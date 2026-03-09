<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Package;
use App\Models\ShipmentOption;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Test
{
    function processSubscription($userId) {
        $user = getUser($userId);
        if (!$user) return false;

        if ($user['active'] && $user['paid']) {
            saveSubscription($userId);
            sendEmail($user['email']);
            logAction($userId, 'subscribed');
        }
    }

    function processSubscription($userId) : bool
    {
        $user = getUser($userId);
        if (!$user) return false;

        if(!$this->canSubscribe($user)){
            return false;
        }

        $this->createSubscription($user);

        return true;
    }

    function canSubscribe(array $user) : bool
    {
        return ($user['active'] && $user['paid']);
    }

    function createSubscription(array $user) : void
    {
        saveSubscription($user['id']);
        sendEmail($user['email']);
        logAction($user['id'], 'subscribed');
    }

    $response = file_get_contents($url);
    $data = json_decode($response, true);
    saveResult($data);

    $response = file_get_contents($url);

    if($response === false){
      error_log("Error in getting result from $url");
      return false;
    }

    $data = json_decode($response, true);
    if(!array( $data)){
        error_log("invalid response $response from $url");
        return;
    }

    saveResult($data);



}



