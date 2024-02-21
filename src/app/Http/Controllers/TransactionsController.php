<?php

namespace App\Http\Controllers;

use Core\Application\Transactions\UserCase\Contracts\IExtractPayerTransactionUserCase;
use Core\Application\Transactions\UserCase\Contracts\IMakeTransactionUseCase;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct(
        private readonly IMakeTransactionUseCase          $makeTransactionUseCase,
        private readonly IExtractPayerTransactionUserCase $extractPayerTransactionUserCase
    )
    {

    }

    public function extract(int $id): ?array
    {
        return $this->extractPayerTransactionUserCase->execute($id);
    }

    public function transaction(Request $request)
    {
        try {
            $this->makeTransactionUseCase->execute(
                $request->get('payer'),
                $request->get('payee'),
                $request->get('value')
            );
            return response()->json([
                'messsage' => 'Transaction created successfully'
            ], 201);
        }catch (\Exception|\Error $exception){
            return response()->json([
                'messsage' => $exception->getMessage(),
            ], 500);
        }
    }

}
