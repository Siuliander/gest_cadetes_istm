<?php // require_once("../includes/conexao.php"); ?>

<?php 

    function BuscarPessoa($Id = NULL , $Identidade = NULL , $Conexao)
    {
        if(@$Conexao)
        {
            $query = "SELECT * FROM tb_pessoa WHERE id_pessoa = 0 LIMIT 1";

            if(@$Id != NULL ): 
                $query = "SELECT * FROM tb_pessoa WHERE id_pessoa = :id LIMIT 1";
            elseif(@$Identidade != NULL ): 
                $query = "SELECT * FROM tb_pessoa WHERE identidade_pessoa = :identidade LIMIT 1";
            elseif(@$Id != NULL & @$Identidade != NULL): 
                $query = "SELECT * FROM tb_pessoa WHERE id_pessoa = :id AND identidade_pessoa = :identidade LIMIT 1";
            endif;
            
            $result = @$Conexao->prepare(@$query);
            
            if(@$Id != NULL): 
                @$result -> bindParam(":id", $Id, PDO::PARAM_INT);
            elseif(@$Identidade != NULL ): 
                @$result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
            elseif(@$Id != NULL & @$Identidade != NULL): 
                @$result -> bindParam(":id", $Id, PDO::PARAM_INT);
                @$result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
            endif;

            @$result->execute(); 
			
            if(@$result->rowCount() > 0 )
            {
                return @$result;
            }
        }

        return FALSE;
    }

    function AddPessoa($Nome = NULL , $Identidade = NULL , $Nascimento = NULL , $Telefone = NULL , $Email = NULL, $Sexo = NULL , $Nacionalidade = NULL , $Sangue = NULL , $Conexao)
    {
		
        if($Nome != NULL & $Identidade != NULL & $Nascimento != NULL):
            
            if(@$Conexao)
            {
                $verificar = BuscarPessoa( NULL , $Identidade , $Conexao );

                if($verificar):
                    return $verificar->fetchobject()->id_pessoa;
                else:
                    $query = "INSERT INTO tb_pessoa (nome_pessoa,identidade_pessoa,telefone,nascimento_pessoa,email,id_sexo,id_nacionalidade,id_sangue) VALUES (:nome,:identidade,:telefone, :nascimento,:email,:sexo,:nacionalidade,:sangue)";
                    

                    $result = @$Conexao->prepare(@$query);

                    $result -> bindParam(":telefone", $Telefone, PDO::PARAM_INT);

                    $result -> bindParam(":nome", $Nome, PDO::PARAM_STR);
                    $result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
                    $result -> bindParam(":nascimento", $Nascimento, PDO::PARAM_STR);
                    $result -> bindParam(":email", $Email, PDO::PARAM_STR);
                    $result -> bindParam(":sexo", $Sexo, PDO::PARAM_INT);
                    $result -> bindParam(":nacionalidade", $Nacionalidade, PDO::PARAM_INT);
                    $result -> bindParam(":sangue", $Nacionalidade, PDO::PARAM_INT);
                    
                    $result->execute();
					

                    if($result->rowCount() > 0 )
                    {
                        return $Conexao->lastInsertId();
                    }

                endif;
            }
        endif;

        return FALSE;
    }

	 
    function UpdatePessoa($Id = 0, $Nome = NULL , $Identidade = NULL , $IdentidadeNova = NULL , $Nascimento = NULL , $Telefone = NULL , $Email = NULL, $Sexo = 0 , $Nacionalidade = 0 , $Sangue = 0 ,$Conexao)
    {

        if($Id != 0 & $Nome != NULL & $Identidade  != NULL & $IdentidadeNova  != NULL & $Nascimento != NULL & $Sexo != 0 & $Nacionalidade != 0 & $Sangue != 0 ):
			
            if(@$Conexao){
                    
                $query = "UPDATE tb_pessoa 
					SET 
						nome_pessoa = :nome , 
						identidade_pessoa = :identidadeNova, 
						telefone = :telefone , 
						email = :email ,
						id_sexo = :sexo ,
						nascimento_pessoa = :nascimento, 
						id_nacionalidade = :nacionalidade ,
						id_sangue = :sangue 
					WHERE  
						id_pessoa = :id AND 
						identidade_pessoa = :identidade 
					LIMIT 1";
					
                $result = @$Conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":nome", $Nome, PDO::PARAM_STR);
                $result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
                $result -> bindParam(":identidadeNova", $IdentidadeNova, PDO::PARAM_STR);
                $result -> bindParam(":telefone", $Telefone, PDO::PARAM_INT);
                $result -> bindParam(":nascimento", $Nascimento, PDO::PARAM_STR);
				$result -> bindParam(":email", $Email, PDO::PARAM_STR);
				$result -> bindParam(":sexo", $Sexo, PDO::PARAM_INT);
				$result -> bindParam(":nacionalidade", $Nacionalidade, PDO::PARAM_INT);
				$result -> bindParam(":sangue", $Sangue, PDO::PARAM_INT);
					
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    return TRUE;
                }
            }

        endif;

        return FALSE;
    }


?>
