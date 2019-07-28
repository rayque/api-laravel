<?php


namespace App\Services;


use App\Models\Usuario;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
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
                'login',
                'email',
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

    public function relatorio()
    {
        $pdf= new FPDF("P", "pt", "A4");
        $pdf->AddPage();

        $pdf->SetFont('arial', 'B', 18);
        $pdf->Cell(0, 5, "Relatorio de Usuarios", 0, 1, 'C');
        $pdf->Cell(0, 5, "", "B", 1, 'C');
        $pdf->Ln(50);

        $pdf->SetFont('arial', 'B', 14);
        $pdf->Cell(95, 20, 'Cod. Pessoa', 1, 0, "C");
        $pdf->Cell(165, 20, 'Nome ', 1, 0, "C");
        $pdf->Cell(200, 20, 'Email', 1, 0, "C");
        $pdf->Cell(65, 20, 'Registro', 1, 1, "C");

        $pdf->SetFont('arial','',12);

        $users = $this->listarUsuarios();

        foreach ($users['data'] as $user){
            $pdf->Cell(95, 20, $user->cod_pessoa, 1, 0, "C");
            $pdf->Cell(165, 20, $user->nome_usuario, 1, 0, "L");
            $pdf->Cell(200, 20, $user->email, 1, 0, "L");
            $pdf->Cell(65, 20, $user->status_usuario , 1, 1, "L");
        }

        $nameFile = 'Relatorio-usuarios.pdf';
        $pdf->Output($nameFile, 'F');
        return response()->file($nameFile);
    }
}
