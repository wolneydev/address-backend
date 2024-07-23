<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    public function enviarEmail(Request $request){
       
        $mensagem = $request->mensagem;
        $destinatario = $request->destinatario;
        $assunto = $request->assunto;
        
        try {
            Mail::raw($mensagem, function ($message) use ($destinatario, $assunto) {
                $message->to($destinatario);
                $message->subject($assunto);
                $message->from(env('MAIL_FROM_ADDRESS'), 'Wolney');
            });
    
            return response()->json(['message' => 'E-mail enviado com sucesso!']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
