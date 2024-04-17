<?php 

    

    $Erro = []; // JSON DE ERRO CONTERÁ "CODIGO DO ERRO" E "MENSAGEM"

    function Error_0()
    { 
        return "<center> <h4> ERRO 0 : LOGIN EXPIRADO </h4></center>";
    }

    function Error_404()
    { 
        return "<center> <h4> ERRO 404 : PÁGINA NÃO ENCONTRADA </h4></center>";
    }
    
    function Error_505()
    { 
        return "<center> <h4> ERRO 505 : SEM PERMISSÃO </h4></center>";
    }

?>