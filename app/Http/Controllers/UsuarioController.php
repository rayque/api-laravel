<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

class UsuarioController extends BaseController
{
    /**
     * @var UsuarioService
     */
    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function listar()
    {
        $dados = $this->usuarioService->listarUsuarios();

        if ($dados['success']) {
            return $this->responseSuccess("Busca de usuários realizada com sucesso!", $dados['data']);
        }

        return $this->responseError("Não foi possível buscar a lista de usuários!");
    }

    public function getDados($id)
    {
        $dados = $this->usuarioService->getDados($id);

        if ($dados['success']) {
            return $this->responseSuccess("Busca de dados do usuário realizada com sucesso!", $dados['data']);
        }

        return $this->responseError("Não foi possível buscar os dados do usuários!");
        
    }

    public function store(Request $request)
    {
        return $this->usuarioService->store($request);
    }


    public function update(Request $request)
    {
        $dados = $this->usuarioService->update($request);

        if ($dados['success']) {
            return $this->responseSuccess("Usuário atualizado com sucesso!", $dados['data']);
        }

        return $this->responseError("Não foi possível atualizar os dados do usuário!");
    }

    public function destroy(Request $request)
    {
        $dados = $this->usuarioService->destroy($request->usuario_id);

        if ($dados['success']) {
            return $this->responseSuccess("Usuário excluído com sucesso!", $dados['data']);
        }

        return $this->responseError("Não foi possível excluir o usuário!");
    }
}
