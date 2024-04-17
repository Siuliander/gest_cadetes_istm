<?php 

    function BuscarPatente($Id = NULL , $conexao)
    {
        
            if(@$conexao){

                $query = "SELECT * FROM tb_patente WHERE estado_patente = 1";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_patente WHERE id_patente = :id LIMIT 1";
                endif;
                
                $result = @$conexao->prepare(@$query);
                
                if(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                endif;

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }
            
        return FALSE;
    }

?>
