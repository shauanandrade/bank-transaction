<?php

namespace App\Infrastructure\Adapters;

use Core\Domain\Contracts\IAuthorisationService;

class AuthorisationAdapter implements IAuthorisationService
{

    public function authorisation(): bool
    {
        $response = $this->requestExternal('url');
        return false;
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
