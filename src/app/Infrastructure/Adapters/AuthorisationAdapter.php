<?php

namespace App\Infrastructure\Adapters;

use Core\Domain\Contracts\IAuthorisationService;

class AuthorisationAdapter implements IAuthorisationService
{
    private string $urlServiceAuthorisation;

    public function __construct()
    {
        $this->urlServiceAuthorisation = getenv('AUTHORISATION_URL');
    }

    public function authorisation(): bool
    {
        try {
            $response = $this->requestExternal($this->urlServiceAuthorisation);

            $autorisationResponse = json_decode($response, true);

            if (isset($autorisationResponse['message']) && $autorisationResponse['message'] === "Autorizado") {
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
