<html>

    <head>
        <title> teste botão  </title>
    </head>


    <body>

        <!--== BOTÃO SIMPLES DO PAGSEGURO APENAS PRA UM ITEM ==-->
        <!-- SÓ RETORNO A ROTA DIRETO PARA ESTE BOTÃO -->

        <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
        <form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post" onsubmit="PagSeguroLightbox(this); return false;">
        <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
        <input type="hidden" name="itemCode" value="3384A2ED6969ED6CC46F0F90C6685181" />
        <input type="hidden" name="iot" value="button" />
        <input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/209x48-pagar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
        </form>
        <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
        <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

    </body>

</html>