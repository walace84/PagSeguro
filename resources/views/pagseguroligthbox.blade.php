<html>

    <head>
        <title> lightbox  </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    </head>


    <body>

        <a href="#" class='btn-buy'>finalizar compra</a>
        <!-- gera um token -->
        {!! csrf_field() !!}
        <!-- div de msg -->
        <div class='msg-return'></div>
        <!-- div de carregamento -->
        <div class='preloader' style='display: none;'>Carregando...</div>

        <!--
            QUANDO CLICAR NO BOTÃO É ENVIADO UM REQUISIÇÃO PARA A ROTA DA URL ABAIXO 
            E RECEBE UM RETORNO QUE ESTÁ DENTRO DO MÉTODO,LIGHTBOX FAZENDO AS VERIFICAÇÕES
            NECESSÁRIO E EFETUANDO O PAGAMENTO.
        -->
        <script>
            $(function(){
                $('.btn-buy').click(function(){
                    // esconde o link.
                    $('.btn-buy').hide();
                    $.ajax({
                        url: '/pagseguro-lightbox',
                        method: 'POST',
                        // token csrf para liberar a entrada.ele é do tipo input.
                        data: {_token: $('input[name=_token]').val()},
                        // quando clicar no botão inicia o carregamento.                       
                        beforeSend: starPreloader()
                    }).done(function(code){ 
                    // chamada a função lightbox
                        lightbox(code);
                       
                    }).fail(function(){
                        alert('Erro inesparado, tenten novamente!');
                    // toda vez que uma requisição é feita no final sempre cai aqui.
                    }).always(function(){
                        stopPreloader();
                    })

                    return false;
                });
            });
            // função para verificar a a condição do pedido.
            function lightbox(code)
            {   // esse PagSeguroLightbox, é do pagseguro!
                // ele recebe o retorno da url(requisição).um código. de compra.
                var AbriLightbox = PagSeguroLightbox({
                    code: code
                }, {
                    success: function(transactionCode){
                        $('.msg-return').html('Pedido realizado com sucesso: ' + transactionCode);
                    },
                    abort: function(){
                        alert('Compra abortada');
                        window.location = "/pagseguro-lightbox";
                    }
                });
                // caso o navegado não tenha suport para ligthbox, manda para está forma de pagamento.
                if(!AbriLightbox)
                {
                    location.href="{{config('pagseguro.url_redirect_after_request')}}"+code;
                }
            }
            // funções de carregamento.
            function starPreloader()
            {
                $('.preloader').show();
            }

            function stopPreloader()
            {
                $('.preloader').hide();
            }


        </script>

        <!-- JAVASCRIPT DO PAGAMENTO LIGTHBOX -->
        <script src="{{config('pagseguro.url_ligthbox_sandbox')}}"> </script>
        <!--
            A integração com o Checkout Lightbox ocorre através de uma API JavaScript,
            portanto o passo seguinte é importar na página de
            pagamento o seguinte JavaScript:
        -->


    </body>

</html>