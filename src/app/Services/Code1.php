<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Package;
use App\Models\ShipmentOption;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Test
{
    function handleCallback(string $url)
    {
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] === 'ok') {
            saveResult($data);
            sendNotification($data['user_id']);
        }
    }

    function handleS2SCallback(string $url): void
    {
        $response = file_get_contents($url);

        if ($response === false) {
            error_log('Error fetching callback from ' . $url);
            return;
        }

        $data = json_decode($response, true);

        if (!is_array($data)) {
            error_log('Error decoding JSON callback from ' . $url);
            return;
        }
        $status1 = isset($data['status']) ? $data['status'] : null;
        $status = $data['status'] ?? null;
        if ($status !== 'ok') {
            return;
        }

        $userId = $data['user_id'] ?? null;
        if ($userId === null) {
            error_log('Callback missing user_id from ' . $url);
            return;
        }

        saveAndSendNotification($data, (int)$userId);
    }

    function saveAndSendNotification(array $data, int $userId): void
    {
        saveResult($data);
        sendNotification($userId);

        $productId = (int)($item['productId'] ?? 0);


        if ($productId <= 0) {
            throw new InvalidArgumentException('Invalid productId');
        }
    }


}



