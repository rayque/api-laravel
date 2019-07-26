<?php

namespace App\Http\Controllers;

use App\Services\AparelhoService;
use Illuminate\Http\Request;

class AparelhoController extends BaseController
{
    /**
     * @var AparelhoService
     */
    private $aparelhoService;

    public function __construct(AparelhoService $aparelhoService)
    {
        $this->aparelhoService = $aparelhoService;
    }

    public function listarAparelhos()
    {
        $dados = $this->aparelhoService->listarAparelhos();

        if ($dados['success']) {
            return $this->responseSuccess("Busca de aparelhos realizada com sucesso!", $dados['data']);
        }

        return $this->responseError("Não foi possível buscar a lista de aparelhos!");
    }
}
