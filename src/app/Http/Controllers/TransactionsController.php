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
    /**
     * @OA\Get(
     *      path="/transaction/extract/{id}",
     *      tags={"Transaction"},
     *      summary="Retorna o extrato de transferencia do usuário",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID do usuário",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista o extrato de transferencia do usuário",
     *      ),
     * )
     */
    public function extract(int $id): ?array
    {
        return $this->extractPayerTransactionUserCase->execute($id);
    }

    /**
     * @OA\Post(
     *      path="/transaction",
     *      tags={"Transaction"},
     *      summary="Faz a transferência",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"payer","payee","value"},
     *                  @OA\Property(
     *                      property="payer",
     *                      type="number",
     *                      example=1,
     *                      description="ID do pagador",
     *                  ),
     *                  @OA\Property(
     *                      property="payee",
     *                      type="number",
     *                      example=2,
     *                      description="ID do beneficiario",
     *
     *                  ),
     *                  @OA\Property(
     *                      property="value",
     *                      type="float",
     *                      example=1352.34,
     *                      description="Valor a transferir",
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Transferência finalizada com sucesso.",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Erro de validação",
     *      ),
     *     @OA\Response(
     *           response=500,
     *           description="Erros internos.",
     *       ),
     * )
     */
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
