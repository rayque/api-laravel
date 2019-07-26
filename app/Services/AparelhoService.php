<?php


namespace App\Services;


use App\Models\Aparelho;
use Illuminate\Support\Facades\Log;
use Throwable;

class AparelhoService
{
    public function listarAparelhos()
    {
        try {
            $dados = Aparelho::all()
            ->map(function ($aparelho) {
                return [
                    'id' => $aparelho->id,
                    'codigo_descricao' => $aparelho->codigo_aparelho . ' - ' .$aparelho->descricao_aparelho,
                ];
            });

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