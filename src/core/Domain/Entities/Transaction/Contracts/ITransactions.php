<?php

namespace Core\Domain\Entities\Transaction\Contracts;

interface ITransactions
{
    public function getOriginUser();
    public function getTargetUser();
    public function makeTransaction();
    public function revertTransation();

}
