<?php 

    function BuscarNacionalidade($Id = NULL , $conexao)
    {
        
            if(@$conexao){

                $query = "SELECT * FROM tb_nacionalidade WHERE estado_nacionalidade = 1";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_nacionalidade WHERE id_nacionalidade = :id LIMIT 1";
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
	
	function VerificarNacionalidade($Valor = NULL , $conexao)
    {
        
       
            if(@$conexao){

                $query = "SELECT * FROM tb_nacionalidade WHERE nacionalidade = :valor LIMIT 1 ";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":valor", $Valor, PDO::PARAM_STR);;
               
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        return FALSE;
    }

    function RecoverNacionalidade($Id = NULL ,$conexao)
    {

        if ( @$Id != NULL ):

            if(@$conexao){

                $query = "UPDATE tb_nacionalidade SET estado_nacionalidade = 1 WHERE estado_nacionalidade = 0 AND id_nacionalidade = :id  LIMIT 1";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarNacionalidade( $Id, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

	
	 function AddNacionalidade($Nacionalidade = NULL , $conexao)
    {
        if( $Nacionalidade != NULL ):
            if(@$conexao){

                $query = "INSERT INTO tb_nacionalidade (nacionalidade) VALUES (:nacionalidade)";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":nacionalidade", $Nacionalidade, PDO::PARAM_STR);

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }
		endif;
            
        return FALSE;
    }

?>
