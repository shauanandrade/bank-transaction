<?php

namespace App\Http\Controllers;

use Core\Application\Users\UserCase\Contracts\ICreateCommonUserUserCase;
use Core\Application\Users\UserCase\Contracts\ICreateShopkeepersUserUserCase;
use Core\Application\Users\UserCase\Contracts\IFindAllUserCase;
use Core\Application\Users\UserCase\Contracts\IFindByCpfOrCnpjUserCase;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(
        private readonly IFindAllUserCase               $findAllUserCase,
        private readonly IFindByCpfOrCnpjUserCase       $findByCPFOrCNPJUserCase,
        private readonly ICreateCommonUserUserCase      $createCommonUserUserCase,
        private readonly ICreateShopkeepersUserUserCase $createShopkeepersUserUserCase,
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/user",
     *      tags={"Users"},
     *      summary="Retorna todos os usuários.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista todos os usuários registrado.",
     *          content={
     *              @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                   type="array",
     *                   required={"fullname","cpf_cnpj","email","password"},
     *                   @OA\Items(
     *                   @OA\Property(
     *                       property="fullname",
     *                       type="string",
     *                       example="Shopkeepers User"
     *                   ),
     *                   @OA\Property(
     *                       property="cpf_cnpj",
     *                       type="string",
     *                       example="12345678901234"
     *                   ),
     *                   @OA\Property(
     *                       property="email",
     *                       type="string",
     *                       format="email",
     *                       example="user@example.com"
     *                   ),
     *                   @OA\Property(
     *                       property="password",
     *                       type="string",
     *                       example="secret"
     *                   ),
     *                   @OA\Property(
     *                       property="wallet",
     *                       type="number",
     *                       format="float",
     *                       example=100.00,
     *                       default=0.00
     *                   ),
     *                   ),
     *               ),
     *               )
     *          }
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado",
     *      ),
     * )
     */
    public function findAll(): array
    {
        return $this->findAllUserCase->execute();
    }

    /**
     * @OA\Get(
     *      path="/user/{cpf_cnpj}",
     *      tags={"Users"},
     *      summary="Retorna um usuário pelo CPF/CNPJ",
     *      @OA\Parameter(
     *          name="cpf_cnpj",
     *          in="path",
     *          required=true,
     *          description="CPF ou CNPJ do usuário",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuário encontrado",
     *          content={
     *              @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                   required={"fullname","cpf_cnpj","email","password"},
     *                   @OA\Property(
     *                       property="fullname",
     *                       type="string",
     *                       example="Shopkeepers User"
     *                   ),
     *                   @OA\Property(
     *                       property="cpf_cnpj",
     *                       type="string",
     *                       example="12345678901234"
     *                   ),
     *                   @OA\Property(
     *                       property="email",
     *                       type="string",
     *                       format="email",
     *                       example="user@example.com"
     *                   ),
     *                   @OA\Property(
     *                       property="password",
     *                       type="string",
     *                       example="secret"
     *                   ),
     *                   @OA\Property(
     *                       property="wallet",
     *                       type="number",
     *                       format="float",
     *                       example=100.00,
     *                       default=0.00
     *                   ),
     *               ),
     *            )
     *          }
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado",
     *      ),
     * )
     */
    public function findByCpfOrCnpj(string $cpf_cnpj)
    {
        return $this->findByCPFOrCNPJUserCase->execute($cpf_cnpj);
    }

    /**
     * @OA\Post(
     *      path="/user/shopkeeper",
     *      tags={"Users"},
     *      summary="Cria um novo usuário lojista",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"fullname","cpf_cnpj","email","password"},
     *                  @OA\Property(
     *                      property="fullname",
     *                      type="string",
     *                      example="Shopkeepers User"
     *                  ),
     *                  @OA\Property(
     *                      property="cpf_cnpj",
     *                      type="string",
     *                      example="12345678901234"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      format="email",
     *                      example="user@example.com"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      example="secret"
     *                  ),
     *                  @OA\Property(
     *                      property="wallet",
     *                      type="number",
     *                      format="float",
     *                      example=100.00,
     *                      default=0.00
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Usuário criado com sucesso",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Erro de validação",
     *      ),
     * )
     */
    public function createShopkeeperUser(Request $request)
    {
        $rs = $this->validate($request, [
            'fullname' => 'required|string',
            'cpf_cnpj' => 'required|string|min:14|max:14|unique:users',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:6',
            'wallet' => 'numeric',
        ]);
        $this->createShopkeepersUserUserCase->execute($rs);
    }

    /**
     * @OA\Post(
     *      path="/user",
     *      tags={"Users"},
     *      summary="Cria um novo usuário comum",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"fullname","cpf_cnpj","email","password"},
     *                  @OA\Property(
     *                      property="fullname",
     *                      type="string",
     *                      example="Common User"
     *                  ),
     *                  @OA\Property(
     *                      property="cpf_cnpj",
     *                      type="string",
     *                      example="12345678901"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      format="email",
     *                      example="user@example.com"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      example="secret"
     *                  ),
     *                  @OA\Property(
     *                      property="wallet",
     *                      type="number",
     *                      format="float",
     *                      example=100.00
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Usuário criado com sucesso",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Erro de validação",
     *      ),
     * )
     */
    public function createCommonUser(Request $request)
    {
        $rs = $this->validate($request, [
            'fullname' => 'required|string',
            'cpf_cnpj' => 'required|string|min:11|max:11|unique:users',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:6',
            'wallet' => 'numeric',
        ]);

        $this->createCommonUserUserCase->execute($rs);
    }


}
