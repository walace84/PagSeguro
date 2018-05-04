<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// pagote Guzzle, FOI BAIXADO NO JSON
use GuzzleHttp\Client as Guzz;

// Essa classe está servindo de dependencia para o controller pagseguro.

class PagSeguro extends Model
{
    // faz uma requisição com esse dados.
    public function generate()
    {
        // São os dados da API do pagseguro, 
        // AS URL ESSTÁ DENTRO DO config() QUE ESTÁ no pagseguro.php.
        // ==  PAGAMENTO PADRÃO == //
        $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'comprador@uol.com.br',
            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',
        ];
        // pega todos os dados e passa para este método de  array do PHP.
        $params = http_build_query($params);

        $guzz = new Guzz;
        // MÉTODO DE ENVIO DOS DADOS ACIMA, para essa URL, que vai gerar um código.
        $reponse = $guzz->request('POST', config('pagseguro.url_checkout_sendbox'), [
            
            'query' => $params,

        ]);
        // pega o corpo do documento
        $body = $reponse->getBody();
        // retorna o xml, que tem a informação que é o código e a data.
        $content = $body->getContents();
        // transforma o xml em uma string.json trazendo o código de transação
        // com esse código podemos redirecionar o usuario.
        $xml = simplexml_load_string($content);
        // captura o código.
        $code = $xml->code;

        return $code;
    }
    // == FIM DO PAGAMENTO PADRÃO == //

    // == PAGAMENTO COM CHECKOUT TRANSPARENTE == //
    // faz uma requisição recupera um código para passar para o ID de sessão.
    // para poder fazer o checkout transparente.
    public function getSessionId()
    {
        $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'), 
        ];

        $params = http_build_query($params);

        $guzz = new Guzz;
        $reponse = $guzz->request('POST', config('pagseguro.url_transparente_session_sendbox'), [
            
            'query' => $params,

        ]);
        $body = $reponse->getBody();
        $content = $body->getContents();
        $xml = simplexml_load_string($content);
        // captura o ID de sessão.
        return $xml->id;
    }


    // == PAGAMENTO COM BOLETO COM CHECKOUT TRANSPARENTE == //
    public function paymentBillet($sendHash)
    {
        $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'senderHash' => $sendHash,
            'paymentMode' => 'default',
            'paymentMethod' => 'boleto',
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'c37628999791810081145@sandbox.pagseguro.com.br',
            'senderCPF' => '10976381702',
            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',
        ];
        //$params = http_build_query($params);

        $guzz = new Guzz;
        $reponse = $guzz->request('POST', config('pagseguro.url_payment_transparente_sandbox'), [
            // esse form_params é da guzzler
            'form_params' => $params,

        ]);
        $body = $reponse->getBody();
        $content = $body->getContents();

        $xml = simplexml_load_string($content);
        // link de pagamento do boleto. vem varias configuração no retorno do xml.
        return $xml->paymentLink; 
    }
    // == FIM PAGAMENTO COM BOLETO == //


    // == PAGAMENTO COM CARTÃO == //
    public function paymentCredCard($request)
    {
        $params = [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
            'senderHash' => $request->senderHash,
            'paymentMode' => 'default',
            'paymentMethod' => 'boleto',
            'currency' => 'BRL',
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
            'reference' => 'REF1234',
            'senderName' => 'Jose Comprador',
            'senderAreaCode' => '99',
            'senderPhone' => '99999999',
            'senderEmail' => 'c37628999791810081145@sandbox.pagseguro.com.br',
            'senderCPF' => '10976381702',
            'shippingType' => '1',
            'shippingAddressStreet' => 'Av. PagSeguro',
            'shippingAddressNumber' => '9999',
            'shippingAddressComplement' => '99o andar',
            'shippingAddressDistrict' => 'Jardim Internet',
            'shippingAddressPostalCode' => '99999999',
            'shippingAddressCity' => 'Cidade Exemplo',
            'shippingAddressState' => 'SP',
            'shippingAddressCountry' => 'ATA',

            'creditCardToken' => $request->cardCard,
            'installmentQuantity' => '1',
            'installmentValue' => '30021.45',
            'noInterestInstallmentQuantity' => '2',
            'creditCardHolderName' => 'Jose Comprador',
            'creditCardHolderCPF' => '1475714734',
            'creditCardHolderBirthDate' => '01/01/1900',
            'creditCardHolderAreaCode' => '9',
            'creditCardHolderPhone' => '9999999',
            'billingAddressStreet' => 'Av. PagSeguro',
            'billingAddressNumber' => '999',
            'billingAddressComplement' => '9o andar',
            'billingAddressDistrict' => 'Jardim Internet',
            'billingAddressPostalCode' => '9999999',
            'billingAddressCity' => 'Cidade Exemplo',
            'billingAddressState' => 'SP',
            'billingAddressCountry' => 'ATA',
        ];

        $guzz = new Guzz;
        $reponse = $guzz->request('POST', config('pagseguro.url_payment_transparente_sandbox'), [
            // esse form_params é da guzzler
            'form_params' => $params,

        ]);
        $body = $reponse->getBody();
        $content = $body->getContents();

        $xml = simplexml_load_string($content);

        return $xml->code;
    }

}
