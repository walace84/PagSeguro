<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagSeguro;

class PagSeguroController extends Controller
{
    // == PAGAMENTO PADRÃO == //
    // injeção de dependencia da Model PagSeguro, onde está vindo a API com todos os dados.
    public function pagseguro(pagseguro $pagseguro)
    {
        // recebe o código que está dentro da função generate(), que vem da Model
        // depois de receber esse código redireciona o usuário
        $code = $pagseguro->generate();
        // URL que redireciona o usuário com o código.para efetuar o pedido.
        $urlRedirect = config('pagseguro.url_redirect_after_request') . $code;
        // função de redirecionamento, rota externa.
        return redirect()->away($urlRedirect);
    }

    // MÉTODO LIGHTBOX
    public function lightbox()
    {
        // REDIRECIONA PARA A VIEW 
        return view('pagseguroligthbox');
    }

    // ESTÁ ROTA É VIA POST, É UMA REQUISIÇÃO QUE ESPERA O RETORNO DE UM CÓDIGO DE COMPRA.
    public function lightboxCode(pagseguro $pagseguro)
    {
        // gera o código de retorno do pagseguro, para efetuar a compra.
        return $pagseguro->generate();
    }



    // == METODO UNIVERSAL DE CHECKOUT TRANSPARENTE == //
    // transparente retorna apenas uma view
    public function transparente()
    {
        return view('pagseguro-transparente');
    }

    // chama o método getSessionId que está recuperando o ID e passado para sessão.
    public function getCode(pagseguro $pagseguro)
    {
        return $pagseguro->getSessionId();
    }
    // == FIM METODO UNIVERSAL DE CHECKOUT TRANSPARENTE == //


    // == METODO PARA PAGAMENTO COM BOLETO == //
    public function billet(Request $request, pagseguro $pagseguro)
    {
        // obtendo o hash do paymentBillet();
        //dd($request->get('sendHash'));
        // retorno da hash de boleto.
        return $pagseguro->paymentBillet($request->sendHash);
    }
    // == FIM DO METODO PARA PAGAMENTO COM BOLETO == //

    // == ROTA DE PAGAMENTO COM CARTÃO == //
    public function card()
    {
        return view('pagseguro-card');
    }



    // == ROTA DE TRANSIÇÃO DO PAGAMENTO COM CARTÃO == //
    // recebe via http todos os dados do formulário.
    public function cardTransation(Request $request, pagseguro $pagseguro)
    {
       return $pagseguro->paymentCredCard($request);
    }
}
