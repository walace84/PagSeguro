<?php

// == ESSES DADOS ESTÁ DENTRO DO ARQUIVO ENV == //
// SÃO O EMAIL E TOKEN DE ACESSO DE VENDEDOR == //

return [
    // AMBIENTE DO PAGSEGURO NO CASO SANDBOX
    'envirorinment' => env('PAGSEGURO_ENVORINMENT'),
    // OS DADOS DE VENDEDOR QUE ESTÁ NO ARQUIVO ENV. ESSE DADOS DE VENDEDOR É USADO PARA TODA API
    'email' => env('PAGSEGURO_EMAIL_SANDBOX'),
    'token' => env('PAGSEGURO_TOKEN_SANDBOX'),

    // == PAGAMENTO PADRÃO == //
    // faz uma requição para está url, retorna um código.
    'url_checkout_sendbox'    => 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout',
    'url_checkout_production' => 'https://ws.pagseguro.uol.com.br/v2/checkout',
    // depois de receber o código retorno o usuario para está url. COM O CÓDIGO. para efetuar o pedido.
    'url_redirect_after_request' => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=',
    // == FIM DO PAGAMENTO PADRÃO == //


    // == PAGAMENTO COM PAGSEGURO LIGTHBOX == //
    'url_ligthbox_sandbox'    => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',
    'url_ligthbox_production' => 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js',
    // == FIM DO PAGAMENTO LIGTHBOX == //

    // == PAGAMENTO COM CHECKOUT TRANSPARENTE == //
    'url_transparente_session_sendbox'   => 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions',
    'url_tranparente_session_production' => 'https://ws.pagseguro.uol.com.br/v2/sessions',

    'url_transparente_js_sanbox'         => 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',
    'url_transparente_js_production'     => 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js',

    // == PAGAMENTO POR BOLETO == /
    'url_payment_transparente_sandbox'  => 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions',
    'url_payment_transparente_production' => 'https://ws.pagseguro.uol.com.br/v2/transactions',

];

// para pegar o toke na produção
// preferencias e integração
// no arquivo .env está os dados de email e token.