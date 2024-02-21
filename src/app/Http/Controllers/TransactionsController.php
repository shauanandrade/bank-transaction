<?php

namespace App\Http\Controllers;

use Core\Application\Transactions\UserCase\Contracts\IMakeTransactionUseCase;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct(
        private readonly IMakeTransactionUseCase $makeTransactionUseCase
    ){

    }

    public function transaction(Request $request)
    {
        $this->makeTransactionUseCase->execute(
            $request->get('payer'),
            $request->get('payee'),
            $request->get('value')
        );
    }

}
