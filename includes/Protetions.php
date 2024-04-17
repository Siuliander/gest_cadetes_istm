<?php 
    function CodificarTexto($Texto = NULL)
    { 
        return  base64_encode(@$Texto);
    }

    function DecodificarTexto($Texto = NULL)
    { 
        return  base64_decode(@$Texto);
    }

    function ProtegeTexto($Texto = NULL)
    { 
        // mysql_escape_string()
        // htmlspecialchars()
        return  htmlspecialchars(@$Texto);
    }
?>