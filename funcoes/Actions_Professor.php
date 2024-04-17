<?php require_once("./funcoes/Actions_Pessoa.php"); ?>

<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    
    
    $nome_pessoa =  ( isset($_POST["nome_pessoa"]) ? $_POST["nome_pessoa"] : (isset($_GET["nome_pessoa"]) ? $_GET["nome_pessoa"] : NULL) );
    $identidade_pessoa =  ( isset($_POST["identidade_pessoa"]) ? $_POST["identidade_pessoa"] : (isset($_GET["identidade_pessoa"]) ? $_GET["identidade_pessoa"] : NULL) );
    $telefone_pessoa =  ( isset($_POST["telefone_pessoa"]) ? $_POST["telefone_pessoa"] : (isset($_GET["telefone_pessoa"]) ? $_GET["telefone_pessoa"] : NULL) );
    $nascimento_pessoa = ( isset($_POST["nascimento_pessoa"]) ? $_POST["nascimento_pessoa"] : (isset($_GET["nascimento_pessoa"]) ? $_GET["nascimento_pessoa"] : NULL) );
    
	$sexo = ( isset($_POST["sexo"]) ? $_POST["sexo"] : (isset($_GET["sexo"]) ? $_GET["sexo"] : NULL) );
    $email = ( isset($_POST["email"]) ? $_POST["email"] : (isset($_GET["email"]) ? $_GET["email"] : NULL) );
    $nacionalidade = ( isset($_POST["nacionalidade"]) ? $_POST["nacionalidade"] : (isset($_GET["nacionalidade"]) ? $_GET["nacionalidade"] : NULL) );
    $sangue_p = ( isset($_POST["sangue"]) ? $_POST["sangue"] : (isset($_GET["sangue"]) ? $_GET["sangue"] : NULL) );
    
    
    $disciplina = ( isset($_POST["disciplina"]) ? $_POST["disciplina"] : (isset($_GET["disciplina"]) ? $_GET["disciplina"] : NULL) );
    $disciplina2 = ( isset($_POST["disciplina2"]) ? $_POST["disciplina2"] : (isset($_GET["disciplina2"]) ? $_GET["disciplina2"] : NULL) );
    $disciplina3 = ( isset($_POST["disciplina3"]) ? $_POST["disciplina3"] : (isset($_GET["disciplina3"]) ? $_GET["disciplina3"] : NULL) );
   
    $id_pessoa = DecodificarTexto( isset($_POST["id_p_up"]) ? $_POST["id_p_up"] : (isset($_GET["id_p_up"]) ? $_GET["id_p_up"] : NULL) );
    $identidadeAntiga = DecodificarTexto( isset($_POST["idd_p_up"]) ? $_POST["idd_p_up"] : (isset($_GET["idd_p_up"]) ? $_GET["idd_p_up"] : NULL) );
    
    $admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;
    $Insered = NULL;

    
    function BuscarDocente($Id = NULL , $IdPessoa = NULL , $Buscar = NULL, $Admin = NULL, $conexao)
    {
        
        if(@$conexao){
            
            $query = "SELECT 
            id_docente, data_docente,estado_docente, pessoa.id_pessoa,
            nome_pessoa, identidade_pessoa,telefone,email,nascimento_pessoa,pessoa.id_sexo,sexo,pessoa.id_sangue,sangue,pessoa.id_nacionalidade,nacionalidade,
                        
            disciplina.id_disciplina, 
            disciplina.disciplina AS disciplina, 
            
            disciplina2.id_disciplina as id_disciplina2,
            disciplina2.disciplina AS disciplina2 ,
            
            disciplina3.id_disciplina as id_disciplina3,
            disciplina3.disciplina AS disciplina3  
            
            FROM tb_docente AS docente 
            
            JOIN tb_pessoa AS pessoa 
            ON pessoa.id_pessoa = docente.id_pessoa 
            
            LEFT JOIN tb_disciplina AS disciplina
            ON disciplina.id_disciplina = docente.id_disciplina
            
            LEFT JOIN tb_disciplina AS disciplina2
            ON disciplina2.id_disciplina = docente.id_disciplina2
            
            LEFT JOIN tb_disciplina AS disciplina3
            ON disciplina3.id_disciplina = docente.id_disciplina3
			
			LEFT JOIN tb_sexo AS sexo 
				ON sexo.id_sexo = pessoa.id_sexo
				
			LEFT JOIN tb_sangue AS sangue 
				ON sangue.id_sangue = pessoa.id_sangue
				
			LEFT JOIN tb_nacionalidade AS nacionalidade
				ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
            
            WHERE estado_docente = 1
                            AND ( pessoa.nome_pessoa like :nomePessoa 
                            OR identidade_pessoa like :identidadePessoa 
                            OR disciplina.disciplina like :disciplina  
                            OR disciplina2.disciplina like :disciplina2 
                            OR disciplina3.disciplina like :disciplina3) ";
            
            if(@$Id != NULL ): 
                $query = "SELECT id_docente, data_docente,estado_docente, pessoa.id_pessoa,
                        nome_pessoa, identidade_pessoa,telefone,email,nascimento_pessoa,pessoa.id_sexo,sexo,pessoa.id_sangue,sangue,pessoa.id_nacionalidade,nacionalidade,
                        disciplina.id_disciplina, 
                        disciplina.disciplina AS disciplina, 
                        
                        disciplina2.id_disciplina as id_disciplina2,
                        disciplina2.disciplina AS disciplina2 ,
                        
                        disciplina3.id_disciplina as id_disciplina3,
                        disciplina3.disciplina AS disciplina3  
                    FROM tb_docente AS docente 
                            JOIN tb_pessoa AS pessoa 
                                ON pessoa.id_pessoa = docente.id_pessoa 
                            
                            LEFT JOIN tb_disciplina AS disciplina
                                ON disciplina.id_disciplina = docente.id_disciplina
                            
                            LEFT JOIN tb_disciplina AS disciplina2
                                ON disciplina2.id_disciplina = docente.id_disciplina2
                            
                            LEFT JOIN tb_disciplina AS disciplina3
                                ON disciplina3.id_disciplina = docente.id_disciplina3
															
							LEFT JOIN tb_sexo AS sexo 
								ON sexo.id_sexo = pessoa.id_sexo
								
							LEFT JOIN tb_sangue AS sangue 
								ON sangue.id_sangue = pessoa.id_sangue
								
							LEFT JOIN tb_nacionalidade AS nacionalidade
								ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
             
                            WHERE estado_docente = 1 
                            AND id_docente = :id LIMIT 1";
                            
            elseif(@$IdPessoa != NULL ): 
                $query = "SELECT * FROM tb_docente WHERE id_pessoa = :idPessoa LIMIT 1";
                
            elseif(@$Id != NULL & @$IdPessoa != NULL): 
                $query = "SELECT 
                id_docente, data_docente, estado_docente,pessoa.id_pessoa,
            nome_pessoa, identidade_pessoa,telefone,email,nascimento_pessoa,pessoa.id_sexo,sexo,pessoa.id_sangue,sangue,pessoa.id_nacionalidade,nacionalidade,
                        disciplina.id_disciplina, 
            disciplina.disciplina AS disciplina, 
            
            disciplina2.id_disciplina as id_disciplina2,
            disciplina2.disciplina AS disciplina2 ,
            
            disciplina3.id_disciplina as id_disciplina3,
            disciplina3.disciplina AS disciplina3  
            
                
                 FROM tb_docente AS docente 
                            JOIN tb_pessoa AS pessoa 
                                ON pessoa.id_pessoa = docente.id_pessoa 
                                
                            LEFT JOIN tb_disciplina AS disciplina
                                ON disciplina.id_disciplina = docente.id_disciplina
                            
                            LEFT JOIN tb_disciplina AS disciplina2
                                ON disciplina2.id_disciplina = docente.id_disciplina2
                            
                            LEFT JOIN tb_disciplina AS disciplina3
                                ON disciplina3.id_disciplina = docente.id_disciplina3
								
						LEFT JOIN tb_sexo AS sexo 
							ON sexo.id_sexo = pessoa.id_sexo
							
						LEFT JOIN tb_sangue AS sangue 
							ON sangue.id_sangue = pessoa.id_sangue
							
						LEFT JOIN tb_nacionalidade AS nacionalidade
							ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
             
                            WHERE estado_docente = 1 
                            AND id_docente = :id AND identidade_pessoa = :identidadePessoa LIMIT 1";
            endif;
            
            $result = @$conexao->prepare(@$query);
            
            if(@$Id != NULL): 
                $result -> bindParam(":id", $Id, PDO::PARAM_STR);
            elseif(@$IdPessoa != NULL ):
                $result -> bindParam(":idPessoa", $IdPessoa, PDO::PARAM_STR);
            elseif(@$Id != NULL & @$IdPessoa != NULL):
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":identidadePessoa", $IdPessoa, PDO::PARAM_INT);
            else:
                $Buscar = "%".$Buscar."%";
                $result -> bindParam(":disciplina", $Buscar, PDO::PARAM_STR);
                $result -> bindParam(":disciplina2", $Buscar, PDO::PARAM_STR);
                $result -> bindParam(":disciplina3", $Buscar, PDO::PARAM_STR);
                $result -> bindParam(":nomePessoa", $Buscar, PDO::PARAM_STR);
                $result -> bindParam(":identidadePessoa", $Buscar, PDO::PARAM_STR);
            endif;

            $result->execute(); 

            if($result->rowCount() > 0 )
            {
                return $result;
            }
        }

        return FALSE;
    }

    

    function RecoverDocente($Id = NULL, $Admin = NULL,$conexao)
    {
        if ( @$Id != NULL & @$Admin != NULL):
            
            if(@$conexao){

                $query = "UPDATE tb_docente SET estado_docente = 1, data_actualizacao_docente = NOW() WHERE estado_docente = 0 AND id_docente = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarDocente($Id , NULL , NULL , $Admin , $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddDocente($Nome = NULL , $Identidade = NULL , $Disciplina = NULL, $Disciplina2 = NULL, $Disciplina3 = NULL, $Nascimento = NULL, $Telefone = NULL,$Email = NULL, $Sexo = NULL , $Nacionalidade = NULL , $Sangue = NULL, $Admin = NULL, $conexao)
    {
        
        if ( @$Nome != NULL & @$Identidade != NULL & @$Admin != NULL):

            if(@$conexao)
            {

                $Pessoa = AddPessoa($Nome,$Identidade,$Nascimento,$Telefone,$Email, $Sexo , $Nacionalidade,$Sangue ,$conexao);
                $Exists = BuscarDocente(NULL, $Pessoa,NULL,$Admin,$conexao);

                
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_docente === "0"):
                        
                        $result = RecoverDocente($dados->id_docente , $Admin , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:
                    
                    $query = "INSERT INTO tb_docente( id_docente,id_pessoa,id_disciplina,id_disciplina2,id_disciplina3,senha_docente,data_docente,data_actualizacao_docente,estado_docente)
                            VALUES ( DEFAULT, :idPessoa, :disciplina, :disciplina2,:disciplina3, MD5(1234), NOW(),NOW(),1)";
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":idPessoa", $Pessoa, PDO::PARAM_INT);
                    $result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
                    $result -> bindParam(":disciplina2", $Disciplina2, PDO::PARAM_INT);
                    $result -> bindParam(":disciplina3", $Disciplina3, PDO::PARAM_INT);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        return TRUE;
                    }

                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteDocente($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao)
            {

				$query = "UPDATE tb_docente SET estado_docente = 0, data_actualizacao_docente = NOW() WHERE estado_docente = 1 AND id_docente = :id";
				$result = @$conexao->prepare($query);
				$result -> bindParam(":id", $Id, PDO::PARAM_INT);
				$result->execute();

				if($result->rowCount() > 0 )
				{
					return TRUE;
				}
		 
            }

        endif;

        return FALSE;
    }

    function UpdateDocente($Id = NULL, $IdPessoa = NULL, $Identidade = NULL, $IdentidadeNova = NULL, $Disciplina=NULL,$Disciplina2=NULL,$Disciplina3=NULL , $Nome = NULL ,  $Nascimento = NULL, $Telefone = NULL, $Email = NULL, $Sexo = 0 , $Nacionalidade = 0 , $Sangue = 0 , $Admin = NULL,$conexao)
    {
        var_dump( $_REQUEST );
		
        if ( @$Id != NULL & @$IdPessoa != NULL & @$IdentidadeNova != NULL & @$Identidade != NULL & @$Admin != NULL):

            if(@$conexao){

                $Exists = BuscarDocente($Id, $IdPessoa, NULL, $Admin, $conexao);
                
                if($Exists):

                    $Pessoa =  UpdatePessoa($IdPessoa, $Nome, $Identidade , $IdentidadeNova , $Nascimento , $Telefone , $Email , $Sexo , $Nacionalidade , $Sangue ,$conexao);
    
                    $dados = $Exists->fetchObject();
				
					$query = "UPDATE tb_docente 
					SET 
					data_actualizacao_docente = NOW(), 
					id_disciplina = :disciplina,
					id_disciplina2 = :disciplina2,
					id_disciplina3 = :disciplina3 
					WHERE estado_docente = 1 AND id_docente = :id LIMIT 1";

					$result = @$conexao->prepare($query);
					
					$result -> bindParam(":id", $Id, PDO::PARAM_INT);
					// $result -> bindParam(":idPessoa", $IdPessoa, PDO::PARAM_INT);
					$result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
					$result -> bindParam(":disciplina2", $Disciplina2, PDO::PARAM_INT);
					$result -> bindParam(":disciplina3", $Disciplina3, PDO::PARAM_INT);
						
					$result->execute();

					if($result->rowCount() > 0 )
					{
						return $result;
					}
					

                endif;

            }

        endif;

        return FALSE;
    }

    
    if ( in_array(DecodificarTexto($pagina) ,["formdocente","viewdocentes"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddDocente($nome_pessoa , $identidade_pessoa , $disciplina, $disciplina2 ,$disciplina3 , $nascimento_pessoa , $telefone_pessoa ,$email,$sexo,$nacionalidade, $sangue_p, $admin , $conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteDocente($id_d,$admin,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateDocente($id , $id_pessoa , $identidadeAntiga , $identidade_pessoa , $disciplina, $disciplina2 ,$disciplina3  , $nome_pessoa ,  $nascimento_pessoa , $telefone_pessoa , $email , $sexo , $nacionalidade , $sangue_p , $admin , $conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverDocente($id, $admin,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarDocente($id , NULL , $buscar , $admin , $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
