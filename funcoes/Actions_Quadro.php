<?php 

    function BuscarQuadro($Id = NULL , $conexao)
    {
        
            if(@$conexao){

                $query = "SELECT * FROM tb_quadro WHERE estado_quadro = 1";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_quadro WHERE id_quadro = :id LIMIT 1";
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
