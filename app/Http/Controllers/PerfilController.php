<?php

namespace App\Http\Controllers;

use App\Services\PerfilService;
use Illuminate\Http\Request;

class PerfilController extends BaseController
{
    /**
     * @var PerfilService
     */
    private $perfilService;

    public function __construct(PerfilService $perfilService)
    {
        $this->perfilService = $perfilService;
    }

    public function listarPerfis()
    {
        $dados = $this->perfilService->listarPerfis();

        if ($dados['success']) {
            return $this->responseSuccess("Busca de perfis realizada com sucesso!", $dados['data']);
        }

        return $this->responseError("Não foi possível buscar a lista de perfis!");
    }
}
