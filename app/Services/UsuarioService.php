<?php


namespace App\Services;


use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class UsuarioService
{
    public function store(Request $request)
    {
        try {
            $dados = [
                'nome_usuario' => $request->nome_usuario,
                'email' => $request->email,
                'login' => $request->login,
                'senha' =>  bcrypt($request->senha),
                'data_creacao' => Carbon::now()->format('Y-m-d'),
                'tempo_expiracao_senha' => $request->tempo_expiracao_senha,
                'cod_autorizacao' => $request->cod_autorizacao,
                'status_usuario' => $request->status_usuario == 'Ativo' ? 'A' : 'I',
                'cod_pessoa' => $request->cod_pessoa,
            ];
            $usuario = Usuario::create($dados);

            $aparelhos = [];
            foreach ($request->selected_aparelho ?? [] as $aparelho) {
                $aparelhos[] = $aparelho['id'];
            }

            $perfis = [];
            foreach ($request->selected_perfil  ?? []  as $perfil) {
                $perfis[] = $perfil['id'];
            }

            $usuario->perfis()->attach($perfis);
            $usuario->aparelhos()->attach($aparelhos);

            return [
                'success' => true,
                'message' => 'Usuário salvo com sucesso!',
            ];

        } catch (Throwable $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            return [
                'success' => false,
                'message' => 'Não foi possível salvar o usuário!',
            ];
        }
    }

    /**
     * @return array
     */
    public function listarUsuarios()
    {
        try {
            $dados = Usuario::select([
                'id',
                'nome_usuario',
                'status_usuario',
                'cod_pessoa',
                'login'
            ])->get();

            foreach ($dados as $dado) {
                $dado->status_usuario = $dado->status_usuario == 'A' ? 'Ativo':  'Inativo';
            }

            return [
                'success' => true,
                'data'  => $dados,
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

    public function destroy($usuarioId)
    {
        try {
            $usuario = Usuario::find($usuarioId);
            $usuario->delete();

            return [
                'success' => true,
                'data' => [],
            ];

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            return [
                'success' => false,
                'data' => [],
            ];
        }
    }

    public function getDados($id)
    {
        try {
            $usuario = Usuario::find($id);

            return [
                'success' => true,
                'data' => $usuario->toArray(),
            ];

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            return [
                'success' => false,
                'data' => [],
            ];
        }
    }

    public function update($request)
    {
        try {
            $usuario = Usuario::find($request->usuario_id);

            $usuario->nome_usuario = $request->nome_usuario;
            $usuario->email = $request->email;
            $usuario->login = $request->login;
            $usuario->senha = bcrypt($request->senha);
            $usuario->tempo_expiracao_senha = $request->tempo_expiracao_senha;
            $usuario->cod_autorizacao = $request->cod_autorizacao;
            $usuario->status_usuario = $request->status_usuario == 'Ativo' ? 'A' : 'I';
            $usuario->cod_pessoa = $request->cod_pessoa;

            $usuario->save();

            $aparelhos = [];
            foreach ($request->selected_aparelho ?? [] as $aparelho) {
                $aparelhos[] = $aparelho['id'];
            }

            $perfis = [];
            foreach ($request->selected_perfil  ?? []  as $perfil) {
                $perfis[] = $perfil['id'];
            }

            $usuario->perfis()->sync($perfis);
            $usuario->aparelhos()->sync($aparelhos);

            return [
                'success' => true,
                'data' => [],
            ];

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());

            return [
                'success' => false,
                'data' => [],
            ];
        }
    }
}