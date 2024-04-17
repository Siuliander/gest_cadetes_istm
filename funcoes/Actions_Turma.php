<?php require_once("./funcoes/Actions_Atribuir_Nota.php"); ?>

<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    $id_a = (DecodificarTexto( isset($_POST["id_a"]) ? @$_POST["id_a"] : (isset($_GET["id_a"]) ? $_GET["id_a"] : NULL) ));
    $id_e = (DecodificarTexto( isset($_POST["id_e"]) ? @$_POST["id_e"] : (isset($_GET["id_e"]) ? $_GET["id_e"] : NULL) ));
    
    $estado = (DecodificarTexto( isset($_POST["est"]) ? @$_POST["est"] : (isset($_GET["est"]) ? $_GET["est"] : NULL) ));
    
    $turma =  ( isset($_POST["turma"]) ? $_POST["turma"] : (isset($_GET["turma"]) ? $_GET["turma"] : NULL) );
    $curso =  ( isset($_POST["curso"]) ? $_POST["curso"] : (isset($_GET["curso"]) ? $_GET["curso"] : NULL) );
    $classe =  ( isset($_POST["classe"]) ? $_POST["classe"] : (isset($_GET["classe"]) ? $_GET["classe"] : NULL) );
    
    $inicio =  ( isset($_POST["anoInicio"]) ? $_POST["anoInicio"] : (isset($_GET["anoInicio"]) ? $_GET["anoInicio"] : NULL) );
    // $encerramento =  ( isset($_POST["anoFim"]) ? $_POST["anoFim"] : (isset($_GET["anoFim"]) ? $_GET["anoFim"] : NULL) );

    
    $admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;

    
    function BuscarTurma($Id = NULL , $Buscar = NULL , $Estado = NULL, $Admin = NULL, $conexao)
    {
        
        if ( @$Admin != NULL):

            if(@$conexao){

                $query = "SELECT * FROM tb_turma_curso AS turma_curso 
                        JOIN tb_curso AS curso ON curso.id_curso = turma_curso.id_curso
                        JOIN tb_turma AS classe ON classe.id_turma = turma_curso.id_turma
                        WHERE estado_turma_curso != 0
                        AND ( turma_curso.turma LIKE :turma OR curso.curso LIKE :curso OR classe.ano LIKE :classe)";

                if(@$Estado != NULL ): 
                    $query = "SELECT * FROM tb_turma_curso AS turma_curso 
                    JOIN tb_curso AS curso ON curso.id_curso = turma_curso.id_curso
                    JOIN tb_turma AS classe ON classe.id_turma = turma_curso.id_turma
                    WHERE estado_turma_curso = :estado";
                endif;  

                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_turma_curso AS turma_curso 
                    JOIN tb_curso AS curso ON curso.id_curso = turma_curso.id_curso
                    JOIN tb_turma AS classe ON classe.id_turma = turma_curso.id_turma
                    WHERE estado_turma_curso != 0 
                    AND id_turma_curso = :id LIMIT 1";
                endif;
                
                $result = @$conexao->prepare(@$query);
                
               if(@$Estado != NULL & @$Id == NULL): 
                   $result -> bindParam(":estado", $Estado, PDO::PARAM_INT);
				elseif(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_STR);
                else:
                    $Buscar = "%".$Buscar."%";
                    $result -> bindParam(":turma", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":curso", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":classe", $Buscar, PDO::PARAM_STR);
                endif;
				

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function VerificarTurma($Valor = NULL , $conexao)
    {
        
        
            if(@$conexao){

                $query = "SELECT * FROM tb_turma_curso WHERE turma = :valor LIMIT 1 ";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":valor", $Valor, PDO::PARAM_STR);
               
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        return FALSE;
    }

    function RecoverTurma($Id = NULL , $AnoInicio = NULL, $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_turma_curso SET estado_turma_curso = 3, ano_inicio_turma = :anoInicio, data_turma_curso = NOW(), id_admin = :admin WHERE estado_turma_curso = 0 AND id_turma_curso = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result -> bindParam(":anoInicio", $AnoInicio, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarTurma( $Id, NULL, NULL , $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddTurma($Curso = NULL, $Classe = NULL, $Turma = NULL, $Inicio = NULL, $Admin = NULL, $conexao)
    {
        
        if ( @$Turma != NULL & @$Admin != NULL):

            if(@$conexao){
                
                $NovaTurma = $Turma . '/' . $Inicio;
                
                $Exists = VerificarTurma($NovaTurma , $conexao);
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_turma_curso === "0"):
                        
                        $result = RecoverTurma($dados->id_turma_curso , $Inicio, $Admin , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:

                    $query = "INSERT INTO tb_turma_curso 
                        (id_turma_curso, id_curso, id_turma, turma, ano_inicio_turma, id_admin, data_turma_curso, estado_turma_curso) 
                        VALUES (DEFAULT, :curso , :classe , :turma , :inicio , :admin , NOW(), 3 );";
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
                    $result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
                    $result -> bindParam(":turma", $NovaTurma, PDO::PARAM_STR);
                    $result -> bindParam(":inicio", $Inicio, PDO::PARAM_INT);
                    $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        $result = BuscarTurma( $conexao->lastInsertId(),NULL,NULL, $Admin, $conexao);
                        return $result;
                    }
                    
                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteTurma($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_turma_curso SET estado_turma_curso = 0 WHERE estado_turma_curso = 3 AND id_turma_curso = :id";
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

    function UpdateTurma($Id = NULL , $Curso = NULL, $Classe = NULL, $Turma = NULL,$Inicio = NULL, $Admin = NULL,$conexao)
    {

        if ( @$Turma != NULL & @$Admin != NULL):

            if(@$conexao){
                
                $NovaTurma = $Turma . '/' . $Inicio;
                
                $query = "UPDATE tb_turma_curso 
                            SET 
                                turma = :turma,
                                id_curso = :curso,
                                id_turma = :classe,
                                ano_inicio_turma = :inicio, 
                                data_turma_curso = NOW(), 
                                id_admin = :admin 
                            WHERE 
                                estado_turma_curso = 3 
                            AND 
                                id_turma_curso = :id";
                
                $result = @$conexao->prepare($query);
                
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":curso", $Curso, PDO::PARAM_INT);
                $result -> bindParam(":classe", $Classe, PDO::PARAM_INT);
                $result -> bindParam(":turma", $NovaTurma, PDO::PARAM_STR);
                $result -> bindParam(":inicio", $Inicio, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                
                
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarTurma($Id,NULL, NULL, $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function ActiveTurma($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_turma_curso SET estado_turma_curso = 2, id_admin = :admin WHERE estado_turma_curso = 3 AND id_turma_curso = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
					AddAtribuirNotas($Id , $conexao);
                    $result = BuscarTurma( $Id, NULL, NULL , $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function CloseTurma($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_turma_curso SET estado_turma_curso = 1, id_admin = :admin WHERE estado_turma_curso = 2 AND id_turma_curso = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
					AddRestringirAtribuirNotas($Id , $conexao);
                    $result = BuscarTurma( $Id, NULL, NULL , $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }
    
    if ( in_array(DecodificarTexto($pagina) ,["formturma","viewturmas"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddTurma($curso, $classe, $turma, $inicio, $admin, $conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteTurma($id_d,$admin,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateTurma($id, $curso, $classe, $turma,$inicio, $admin,$conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverTurma($id , $inicio, $admin ,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarTurma($id,$buscar, $estado, $admin, $conexao);
                break;
                
            case 'active':
                //echo "Caso: Delete";
                ActiveTurma($id_a,$admin,$conexao);
                break;
                
            case 'close':
                //echo "Caso: Delete";
                CloseTurma($id_e,$admin,$conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
