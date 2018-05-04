<!DOCTYPE html>
<html lang="en">
    <head>
        <title>pagamento com cartão</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
        <br>
        <h1>Pagamento com Cartão</h1>

        <form  id='form'>
             {!! csrf_field() !!}
            <div class="form-group">
                Número do cartão:
                <input type="text" class="form-control" name='cardNumber'>
            </div>

            <div class="form-group">
                Mês de expiração:
                <input type="text" class="form-control" name='cardExpiryMonth'>
            </div>

            <div class="form-group">
                Ano de expiração:
                <input type="text" class="form-control" name='cardExpiryYear'>
            </div>

            <div class="form-group">
                Código de segurança
                <input type="" class="form-control" name='cardCVV'>
            </div>
            <input type='hidden' name='cardName'>
            <input type='hidden' name='cardCard'>
            
            <button type="submit" class="btn btn-primary bot">Submit</button>
           
        </form>


            <div class='preloader' style='display: none;'>preloader...</div>
            <div class='message'style='display: nome;'></div>

        </div>

        <!-- == URL DO PAGAMENTO COM CHECKOUT TRANSPARENTE == -->
        <script src="{{config('pagseguro.url_transparente_js_sanbox')}}"></script>

        <script>
            $(function(){
                setSessionId();

                $('#form').submit(function(){
                    getBrand();
                    starPreloader();
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
                    data: data,
                    beforeSend: starPreloader('Criando a sessão')
                }).done(function(data){
                    // pega o retorno do ID do usuário.e cria a sessão.
                    PagSeguroDirectPayment.setSessionId(data);

                }).fail(function(){
                    alert('FAil request...');
                }).always(function(){
                    stopPreloader();
                })
            }

            // metodo pra pegar a bandeira do cartão, antes de capturar a bandeira é preciso saber o id do cliente.
            function getBrand()
            {
                PagSeguroDirectPayment.getBrand({

                    cardBin: $('input[name=cardNumber]').val().replace(/ /g,''),

                    success: function(response){
                         console.log('certo getBrand');
                        console.log(response);
                        // opcional só para mostrar o nome do cartão
                        $('input[name=cardName]').val(response.brand.name);
                        // executa o o método de token.
                        createCardToken();
                    },
                    error: function(response){
                         console.log('erro getBrand');
                        console.log(response);
                    },
                    complete: function(response){
                         console.log('sucesso getBrand');
                        console.log(response);
                        
                    }
                });
            }

            // == Obter o token de cartão de crédito para validação == //
            // dados do formulário.
            function createCardToken()
            {
                PagSeguroDirectPayment.createCardToken({
                    cardNumber: $('input[name=cardNumber]').val().replace(/ /g,''),
                    brand: $('input[name=cardName]').val(),
                    cvv: $('input[name=cardCVV]').val(),
                    expirationMonth: $('input[name=cardExpiryMonth]').val(),
                    expirationYear: $('input[name=cardExpiryYear]').val(),

                    success: function(response) {
                        console.log('Sucess creatCard');
                        console.log(response);
                        // opcional só para mostrar o token do cartão.
                        $("input[name=cardCard]").val(response.card.token);
                        // quando obter os dados do cartão, inicia a transição de pagamento
                        createTransitionCard();
                    },
                    error: function(response) {
                       console.log('Erro creatCard');
                        console.log(response);
                    },
                    complete: function(response) {
                       console.log('Sucess creat');
                        console.log(response);
                        stopPreloader();
                    }
                });
            } 

            // MÉTODO DE TRANSIÇÃO DE PAGAMENTO
            function createTransitionCard()
            {
                var sendHash = PagSeguroDirectPayment.getSenderHash();
                // recupera os valores do form.
                var data = $('#form').serialize()+"&senderHash="+sendHash;
                $.ajax({
                    url: '/pagseguro-trasnparente-cartao',
                    method: 'POST',
                    data: data,
                    beforeSend: starPreloader('Realizando o pagamento com o cartão.')
                }).done(function(code){
                    $(".message").html("Código da transação: "+code);
                    $(".message").show();
                }).fail(function(){
                    alert('FAil request...');
                }).always(function(){
                    stopPreloader();
                })
            }

            // == Preloader do sistema == //
            function starPreloader(msgCarregando)
            {
                if(msgCarregando != "")
                    $('.preloader').html(msgCarregando);

                $('.preloader').show();
                $('.bot').addClass();
            }


            function stopPreloader()
            {
                $('.preloader').hide();
                $('.bot').removeClass();
            }

        </script>

    </body>
</html>