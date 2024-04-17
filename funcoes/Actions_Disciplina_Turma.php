<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    $id_a = (DecodificarTexto( isset($_POST["id_a"]) ? @$_POST["id_a"] : (isset($_GET["id_a"]) ? $_GET["id_a"] : NULL) ));
    $id_e = (DecodificarTexto( isset($_POST["id_e"]) ? @$_POST["id_e"] : (isset($_GET["id_e"]) ? $_GET["id_e"] : NULL) ));
    
    $estado = (DecodificarTexto( isset($_POST["est"]) ? @$_POST["est"] : (isset($_GET["est"]) ? $_GET["est"] : NULL) ));
    
    $curso =  ( isset($_POST["curso"]) ? $_POST["curso"] : (isset($_GET["curso"]) ? $_GET["curso"] : NULL) );
    $classe =  ( isset($_POST["classe"]) ? $_POST["classe"] : (isset($_GET["classe"]) ? $_GET["classe"] : NULL) );
    $disciplina =  ( isset($_POST["disciplina"]) ? $_POST["disciplina"] : (isset($_GET["disciplina"]) ? $_GET["disciplina"] : NULL) );
    
	$admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;
	
	$result = NULL;
    $linha = NULL;

    
    function BuscarDisciplinaTurma($Id = NULL , $Buscar = NULL , $Curso = NULL, $Classe = NULL, $Disciplina = NULL, $conexao)
    {
		if(@$conexao){

			$query = "SELECT * FROM tb_disciplina_turma AS disciplina_turma 
					JOIN tb_curso AS curso ON curso.id_curso = disciplina_turma.id_curso
					JOIN tb_turma AS classe ON classe.id_turma = disciplina_turma.id_turma
					JOIN tb_disciplina AS disciplina ON disciplina.id_disciplina = disciplina_turma.id_disciplina
					WHERE estado_disciplina_turma = 1 ";

			if(@$Id != NULL ): 
				$query = $query . " AND id_disciplina_turma = :id";
			elseif(@$Curso != NULL ): 
				$query = $query . " AND id_curso = :curso";
			elseif(@$Classe != NULL ): 
				$query = $query . " AND id_turma = :classe";
			elseif(@$Disciplina != NULL ): 
				$query = $query . " AND id_disciplina = :disciplina";
			endif;
			
			$result = @$conexao->prepare(@$query);
			
			if(@$Id != NULL ): 
				$result -> bindParam(":id", $Id, PDO::PARAM_STR);
			elseif(@$Curso != NULL ): 
				$result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
			elseif(@$Classe != NULL ): 
				$result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
			elseif(@$Disciplina != NULL ): 
				$result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
			endif;

			$result->execute(); 

			if($result->rowCount() > 0 )
			{
				return $result;
			}
		}

        return FALSE;
    }

    function VerificarDisciplinaTurma($Curso = NULL,$Classe = NULL,$Disciplina = NULL, $conexao)
    {
        
        
            if(@$conexao){

                $query = "SELECT * FROM tb_disciplina_turma WHERE id_curso = :curso AND id_turma = :classe AND id_disciplina = :disciplina LIMIT 1 ";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
                $result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
                $result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
               
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        return FALSE;
    }

    function RecoverDisciplinaTurma($Id = NULL , $Curso = NULL,$Classe = NULL,$Disciplina = NULL,$conexao)
    {

        if ( @$Id != NULL ):

            if(@$conexao){

                $query = "UPDATE tb_disciplina_turma SET estado_disciplina_turma = 1 WHERE estado_disciplina_turma = 0 AND ( id_disciplina_turma = :id OR (id_curso = :curso AND id_turma = :classe AND id_disciplina = :disciplina)";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
                $result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
                $result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarDisciplinaTurma($Id, NULL , $Curso , $Classe , $Disciplina , $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddDisciplinaTurma($Curso = NULL, $Classe = NULL, $Disciplina = NULL, $conexao)
    {
   
        if ( @$Curso != NULL & @$Classe != NULL & @$Disciplina != NULL):

            if(@$conexao){
                
                
                $Exists = VerificarDisciplinaTurma($Curso,$Classe,$Disciplina,$conexao);
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_disciplina_turma === "0"):
                        
                        $result = RecoverTurma($dados->id_disciplina_turma , $Curso,$Classe,$Disciplina, $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:

                    $query = "INSERT INTO tb_disciplina_turma
                                ( id_curso, id_turma, id_disciplina, estado_disciplina_turma )
                              VALUES 
                                ( :curso, :classe, :disciplina, 1 );";
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
                    $result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
                    $result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        $result = BuscarDisciplinaTurma( $conexao->lastInsertId(),NULL,NULL,NULL,NULL, $conexao);
                        return $result;
                    }
                    
                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteDisciplinaTurma($Id = NULL ,$conexao)
    {

        if ( @$Id != NULL ):

            if(@$conexao){

                $query = "UPDATE tb_disciplina_turma SET estado_disciplina_turma = 0 WHERE estado_disciplina_turma = 1 AND id_disciplina_turma = :id";
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

    function UpdateDisciplinaTurma($Id = NULL , $Curso = NULL, $Classe = NULL, $Disciplina = NULL,$conexao)
    {

        if ( $Id != NULL & $Curso != NULL & $Classe != NULL & $Disciplina != NULL ):

            if(@$conexao){
                
                $query = "UPDATE tb_disciplina_turma 
                            SET 
                                id_curso = :curso,
                                id_turma = :classe,
                                id_disciplina = :disciplina
                            WHERE 
                                estado_disciplina_turma = 1 
                            AND 
                                id_disciplina_turma = :id";
                
                $result = @$conexao->prepare($query);
                
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
                $result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
                $result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_INT);
                
                
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarDisciplinaTurma( $conexao->lastInsertId(),NULL,NULL,NULL,NULL, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    
    if ( in_array(DecodificarTexto($pagina) ,["formdisciplinaturma","viewdisciplinasturmas"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddDisciplinaTurma($curso, $classe, $disciplina, $conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteDisciplinaTurma($id_d,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateDisciplinaTurma($id, $curso, $classe, $disciplina,$conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverDisciplinaTurma($id , $conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarDisciplinaTurma($id,$buscar, null,null,null, $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
