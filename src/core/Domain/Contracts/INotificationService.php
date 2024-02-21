<?php

namespace Core\Domain\Contracts;

interface INotificationService
{
    public function sendNotification(): bool;
}
