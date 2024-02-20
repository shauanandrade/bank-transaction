<?php

namespace App\Http\Controllers;

use Core\Application\Users\Contracts\ICreateCommonUserUserCase;
use Core\Application\Users\Contracts\IFindAllUserCase;
use Core\Application\Users\Contracts\IFindByCpfOrCnpjUserCase;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(
        private readonly IFindAllUserCase $findAllUserCase,
        private readonly IFindByCpfOrCnpjUserCase $findByCPFOrCNPJUserCase,
        private readonly ICreateCommonUserUserCase $createCommonUserUserCase
    )
    {
    }

    public function findAll(): array
    {
        return $this->findAllUserCase->execute();
    }

    public function findByCpfOrCnpj(string $cpf_cnpj)
    {
        return $this->findByCPFOrCNPJUserCase->execute($cpf_cnpj);
    }

    public function createCommonUser(Request $request){
//        $rs  = $this->validate($request,[
//            'fullname'=>'required|string',
//            'cpf_cnpj'=>'required|string|min:11|max:11|unique:users',
//            'email'=>'required|string|max:255|email|unique:users',
//            'password'=>'required|string|min:6',
//            'wallet'=>'numeric',
//        ]);

        $this->createCommonUserUserCase->execute($request->all());
    }

}
