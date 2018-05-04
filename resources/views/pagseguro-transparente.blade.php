<html>

    <head>
        <title> Transparente </title>

    </head>


    <body>
        <a href='#' class='btn-finished'>Pagar com boleto</a>
        <form id='form' action=''>
          {!! csrf_field() !!}
        </form>


        <div class='payment-method'> </div>     

        <!-- == URL DO PAGAMENTO COM CHECKOUT TRANSPARENTE == -->
        <script src="{{config('pagseguro.url_transparente_js_sanbox')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          
        <!-- == METODO UNIVERSAL DE CHECKOUT TRANSPARENTE == -->  
        <script>
            $(function(){
                $('.btn-finished').click(function(){
                    setSessionId();
                        
                    return false;
                });
            });
            // método que seta a sessão
            function setSessionId()
            {
                // para pegar os dados do formulário no caso o csrf
                var data = $('#form').serialize();

                $.ajax({
                    // faz a requisição para está rota. e da um returno do ID,vai no 
                    // método getCode().
                    url: '/pagseguroTransparente',
                    method: 'POST',
                    data: data
                    // pega o retorno do ID do usuário.
                }).done(function(data){
                    PagSeguroDirectPayment.setSessionId(data);

                    paymentBillet();
                    //executo os meios de pagamentos disponiveis.opcional
                    //getPaymentMethods();
                }).fail(function(){
                    alert('FAil request...');
                });
            }
            // método para retorna o meio de pagamento
            function getPaymentMethods()
            {
                PagSeguroDirectPayment.getPaymentMethods({
                    success: function(response){
                        // essas soluções está no console.log().
                        console.log(response);
                        if(response.error == false)
                        {   // loop em Jquery.para perrcorre os metodos de pagamento.
                            $.each(response.paymentMethods, function(key, value){
                                $('.payment-method').append(key+"<br>");
                            });
                        }
                    },
                    error: function(response){
                        console.log(response);
                    },
                    complete: function(response){
                        //console.log(response);
                    }
                });
            }
            
            // == METODO DE PAGAMENTO COM BOLETO == //
            function paymentBillet()
            {
                // retorna o hash do comprador.
                var sendHash = PagSeguroDirectPayment.getSenderHash();
                // concatenando os dados e enviando pelo formulário.
                var data = $('#form').serialize()+"&sendHash="+sendHash;

                $.ajax({
                    // faz a requisição para está rota.
                    url: '/pagsegurobillet',
                    method: 'POST',
                    data: data
                }).done(function(url){
                    //console.log(data);
                    location.href=url;
                }).fail(function(){
                    alert('FAil request...');
                });
            }
             // == FIM DO METODO DE PAGAMENTO COM BOLETO == //

        </script>
         
    </body>

</html>