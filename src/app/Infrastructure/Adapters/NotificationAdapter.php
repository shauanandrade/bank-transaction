<?php

namespace App\Infrastructure\Adapters;

use Core\Domain\Contracts\IAuthorisationExternal;
use Core\Domain\Contracts\INotificationExternal;
use Core\Domain\Entities\Transaction\Contracts\ITransactionsEntity;

class NotificationAdapter implements INotificationExternal
{
    private string $urlNotificationService;

    public function __construct()
    {
        $this->urlNotificationService = getenv('NOTIFICATION_URL');
    }

    public function sendNotification(ITransactionsEntity $transactionsEntity): bool
    {
        try {
            $response = $this->requestExternal($this->urlNotificationService);

            $autorisationResponse = json_decode($response, true);

//            $payerEmail = $transactionsEntity->getPayer()->getEmail()->getValue();
//            $payeeEmail = $transactionsEntity->getPayee()->getEmail()->getValue();
            
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
