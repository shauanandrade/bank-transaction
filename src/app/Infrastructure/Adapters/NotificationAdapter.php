<?php

namespace App\Infrastructure\Adapters;

use Core\Domain\Contracts\IAuthorisationService;
use Core\Domain\Contracts\INotificationService;

class NotificationAdapter implements INotificationService
{

    public function sendNotification(): bool
    {
        $request = $this->requestExternal('url_external');
        return true;
    }

    private function requestExternal(string $url): ?string
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);;

        return $response;
    }
}
