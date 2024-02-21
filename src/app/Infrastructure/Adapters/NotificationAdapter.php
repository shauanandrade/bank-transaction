<?php

namespace App\Infrastructure\Adapters;

use Core\Domain\Contracts\IAuthorisationService;
use Core\Domain\Contracts\INotificationService;

class NotificationAdapter implements INotificationService
{
    private string $urlNotificationService;

    public function __construct()
    {
        $this->urlNotificationService = getenv('NOTIFICATION_URL');
    }

    public function sendNotification(): bool
    {
        try {
            $response = $this->requestExternal($this->urlNotificationService);

            $autorisationResponse = json_decode($response, true);

            if (isset($autorisationResponse['message']) && $autorisationResponse['message'] === true) {
                return true;
            }
            return false;
        } catch (\Exception $exception) {
            return false;
        }
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
