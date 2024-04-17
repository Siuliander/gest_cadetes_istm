<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));

    $id_a = (DecodificarTexto( isset($_POST["id_a"]) ? @$_POST["id_a"] : (isset($_GET["id_a"]) ? $_GET["id_a"] : NULL) ));
    
    $id_cadete = (DecodificarTexto( isset($_POST["id_c"]) ? @$_POST["id_c"] : (isset($_GET["id_c"]) ? $_GET["id_c"] : NULL) ));
    $turma  =  ( isset($_POST["turma"]) ? $_POST["turma"] : (isset($_GET["turma"]) ? $_GET["turma"] : NULL) );
    $curso  =  ( isset($_POST["curso"]) ? $_POST["curso"] : (isset($_GET["curso"]) ? $_GET["curso"] : NULL) );
    $classe =  ( isset($_POST["classe"]) ? $_POST["classe"] : (isset($_GET["classe"]) ? $_GET["classe"] : NULL) );
    
    $admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;


    function BuscarMatriculados($Id = NULL, $Cadete = NULL , $Turma = NULL, $Buscar = NULL, $conexao)
    {
        
            if(@$conexao){

                $query = "SELECT * FROM tb_matricula matricula

                            JOIN tb_aluno aluno
                            ON aluno.id_aluno = matricula.id_aluno
                            
                            JOIN tb_pessoa pessoa
                            ON pessoa.id_pessoa = aluno.id_pessoa
							
							JOIN tb_sexo sexo 
							ON sexo.id_sexo = pessoa.id_sexo
							
							LEFT JOIN tb_sangue AS sangue 
								ON sangue.id_sangue = pessoa.id_sangue
								
							LEFT JOIN tb_nacionalidade AS nacionalidade
								ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
                            
                            JOIN tb_turma_curso turma
                            ON turma.id_turma_curso = matricula.id_turma_curso
                            
                            JOIN tb_curso curso
                            ON curso.id_curso = turma.id_curso
                            
                            JOIN tb_turma ano
                            ON ano.id_turma = turma.id_turma

                        WHERE estado_matricula > 0 AND estado_aluno = 1 
                        AND (turma.turma LIKE :turma OR curso.curso LIKE :curso OR nome_pessoa LIKE :pessoa OR identidade_pessoa LIKE :identidade)";

                                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_matricula  matricula

                            JOIN tb_aluno aluno
                            ON aluno.id_aluno = matricula.id_aluno
                            
                            JOIN tb_pessoa pessoa
                            ON pessoa.id_pessoa = aluno.id_pessoa
							
							JOIN tb_sexo sexo 
							ON sexo.id_sexo = pessoa.id_sexo
							
							LEFT JOIN tb_sangue AS sangue 
								ON sangue.id_sangue = pessoa.id_sangue
								
							LEFT JOIN tb_nacionalidade AS nacionalidade
								ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
                            
                            JOIN tb_turma_curso turma
                            ON turma.id_turma_curso = matricula.id_turma_curso
                            
                            JOIN tb_curso curso
                            ON curso.id_curso = turma.id_curso
                            
                            JOIN tb_turma ano
                            ON ano.id_turma = turma.id_turma

                            WHERE id_matricula = :id  AND estado_aluno = 1  LIMIT 1";
				// elseif(@$Cadete != NULL & @$Turma != NULL ):
					
                endif;
                
                $result = @$conexao->prepare(@$query);
                
                if(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_STR);
				/* 
					elseif(@$Cadete != NULL & @$Turma != NULL ):
                    $result -> bindParam(":cadete", $Cadete, PDO::PARAM_INT);
                    $result -> bindParam(":turma", $Turma, PDO::PARAM_INT);
                */
				else:
                    $Buscar = "%".$Buscar."%";
                    $result -> bindParam(":turma", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":curso", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":pessoa", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":identidade", $Buscar, PDO::PARAM_STR);
                endif;

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }


        return FALSE;
    }
	
	function VerificarMatriculaTurma($Cadete = NULL, $Turma = NULL , $conexao)
    {
		if(@$conexao){
			$query = "SELECT * FROM tb_matricula WHERE id_aluno = :cadete AND id_turma_curso = :turma LIMIT 1 ";
			$result = @$conexao->prepare(@$query);
			$result -> bindParam(":cadete", $Cadete, PDO::PARAM_INT);
			$result -> bindParam(":turma", $Turma, PDO::PARAM_INT);
			$result->execute(); 
			if($result->rowCount() > 0 )
			{
				return $result;
			}
		}
        return FALSE;
    }

    function VerificarMatricula($Cadete = NULL, $conexao)
    {
		if(@$conexao){
			$query = "SELECT * FROM tb_matricula WHERE id_aluno = :cadete ";
			$result = @$conexao->prepare(@$query);
			$result -> bindParam(":cadete", $Cadete, PDO::PARAM_INT);
			$result->execute(); 
			if($result->rowCount() > 0 )
			{
				return $result;
			}
		}
        return FALSE;
    }

    function RecoverMatricula($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_matricula SET estado_matricula = 1 WHERE estado_matricula= 0 AND id_matricula = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarMatriculados( $Id, NULL, NULL,NULL, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddMatricula($Cadete = NULL, $Turma = NULL, $Admin = NULL, $conexao)
    {
        
        if ( @$Turma != NULL & @$Admin != NULL):

            if(@$conexao){
                
                $Exists = VerificarMatricula($Cadete, $conexao);
                $ExistsMT = VerificarMatriculaTurma($Cadete , $Turma, $conexao);
                
                if($Exists):
				
                    $dados = $Exists->fetchObject();
					
                    // $dados = $Exists->fetchAll();
					
					// var_dump( $dados );
                    
                    if( $dados->estado_matricula == "0" ):
                        
                        $result = RecoverMatricula($dados->id_matricula , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                    endif;
					
					if( $dados->estado_matricula == "2" /* & $dados->id_turma_curso != $Turma */ ):
					
                        $query = "INSERT INTO tb_matricula 
                        (id_aluno, id_turma_curso) 
                        VALUES (:cadete , :turma );";
						
						$result = @$conexao->prepare(@$query);
						
						$result -> bindParam(":cadete", $Cadete, PDO::PARAM_STR);
						$result -> bindParam(":turma", $Turma, PDO::PARAM_STR);
						$result->execute();

						if($result->rowCount() > 0 )
						{
							$result = BuscarMatriculados( $conexao->lastInsertId(),NULL,NULL,NULL, $conexao);
							return $result;
						}
						
					endif;
					
                else:
					
                    $query = "INSERT INTO tb_matricula 
                        (id_aluno, id_turma_curso) 
                        VALUES (:cadete , :turma );";
						
                    $result = @$conexao->prepare(@$query);
					
                    $result -> bindParam(":cadete", $Cadete, PDO::PARAM_STR);
                    $result -> bindParam(":turma", $Turma, PDO::PARAM_STR);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        $result = BuscarMatriculados( $conexao->lastInsertId(),NULL,NULL,NULL, $conexao);
                        return $result;
                    }
                    
                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteMatricula($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_matricula SET estado_matricula = 0 WHERE id_matricula = :id LIMIT 1";
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

    function UpdateMatricula($Id = NULL , $Cadete = NULL, $Turma = NULL, $Admin = NULL,$conexao)
    {

        if ( @$Turma != NULL & @$Admin != NULL):

            if(@$conexao){
                
                $query = "UPDATE tb_matricula 
                            SET 
                                id_cadete = :cadete,
                                id_turma = :turma
                            WHERE 
                                estado_matricula = 1
                            AND 
                                id_matricula = :id";
                
                $result = @$conexao->prepare($query);
                
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":cadete", $Cadete, PDO::PARAM_INT);
                $result -> bindParam(":turma", $Turma, PDO::PARAM_INT);
                
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarMatricula($Id,NULL, NULL,NULL, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }
    
    if ( in_array(DecodificarTexto($pagina) ,["formmatricula","viewmatriculas"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddMatricula($id_cadete, $turma, $admin, $conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteMatricula($id_d,$admin,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateMatricula($id, $id_cadete, $turma, $admin,$conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverMatricula($id , $admin ,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarMatriculados($id,$id_cadete,$turma,$buscar, $conexao);
                break;
                
            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
