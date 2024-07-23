<?php
 
namespace App\Http\Middleware;
 
use Closure;

use Illuminate\Support\Facades\DB;
use Throwable;
 
class TransactionMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verifica se a solicitação é uma requisição GET
        if ($request->isMethod('get')) {
            // Se for uma requisição GET, simplesmente continua sem iniciar a transação
            return $next($request);
        }
 
        // Inicia a transação para outros tipos de requisição
        DB::beginTransaction();
        try {
            $response = $next($request);
 
            if ($response->isSuccessful()) {           
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Throwable $e) {
            DB::rollBack();
 
            throw $e; // Lançar o erro para ser tratado pelo Laravel
 
            // Alternativamente, você pode retornar uma resposta de erro personalizada:
            // return response()->json(['error' => 'Ocorreu um erro.'], 500);
        }
 
        return $response;
    }
}