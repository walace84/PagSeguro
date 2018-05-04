<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// ROTA DA TRANSÃO COM PARAGAMENTO COM CARTÃO
Route::post('pagseguro-trasnparente-cartao', 'PagSeguroController@cardTransation');
// ROTA DE PAGAMENTO COM CARTÃO
Route::get('pagseguro-trasnparente-cartao', 'PagSeguroController@card');
// ROTA DE PAGAMENTO COM BOLETO
Route::post('pagsegurobillet', 'PagSeguroController@billet');
// RETORNA UM CÓDIGO PARA ARMAZENAR NA SESSÃO.
Route::post('pagseguroTransparente', 'PagSeguroController@getCode');
// ROTA DE PAGAMENTO TRANSPARENTE
Route::get('pagseguroTransparente', 'PagSeguroController@transparente');
// ROTA DO PAGAMENTO LIGHTBOX
Route::get('pagseguro-lightbox','PagSeguroController@lightbox');
// ROTA DO PAGAMENTO LIGTHBOX, RECEBE O CÓDIGO DE PAGAMENTO.
Route::post('pagseguro-lightbox','PagSeguroController@lightboxCode');
// ROTA DO PAGAMENTO PADRÃO.
Route::get('pagseguro','PagSeguroController@pagseguro');





// Rota do botão simples
Route::get('pagseguro-btn', function(){
    return view('pagseguro-btn');
});

Route::get('/', function () {
    return view('welcome');
});
