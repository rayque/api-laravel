<?php


namespace App\Services;


use App\Models\Perfil;
use Illuminate\Support\Facades\Log;
use Throwable;

class PerfilService
{
    public function listarPerfis()
    {
        try {
            $dados = Perfil::select([
                'nome_perfil as nome',
                'id',
            ])->get();

            return [
                'success' => true,
                'data'  => $dados->toArray(),
            ];

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            return [
                'success' => false,
                'data' => [
                    $exception->getMessage(),
                ],
            ];
        }
    }

}