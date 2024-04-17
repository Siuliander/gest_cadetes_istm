<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    
    $curso =  ( isset($_POST["curso"]) ? $_POST["curso"] : (isset($_GET["curso"]) ? $_GET["curso"] : NULL) );
    
	$admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;

    
    function BuscarCurso($Id = NULL , $Buscar = NULL , $Admin = NULL, $conexao)
    {
        
        if ( @$Admin != NULL):

            if(@$conexao){

                $query = "SELECT * FROM tb_curso curso 
                            JOIN tb_admin admin 
                                ON admin.id_admin = curso.id_admin 
                            JOIN tb_pessoa pessoa 
                                ON pessoa.id_pessoa = admin.id_pessoa 
                            WHERE estado_curso = 1 
                            AND (curso.curso LIKE :buscar 
                            OR pessoa.nome_pessoa like :nomePessoa 
                            OR identidade_pessoa like :identidadePessoa ) ";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_curso curso 
                                JOIN tb_admin admin 
                                    ON admin.id_admin = curso.id_admin 
                                JOIN tb_pessoa pessoa 
                                    ON pessoa.id_pessoa = admin.id_pessoa 
                                WHERE estado_curso = 1 
                                AND id_curso = :id LIMIT 1";
                endif;
                
                $result = @$conexao->prepare(@$query);
                
                if(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_STR);
                else:
                    $Buscar = "%".$Buscar."%";
                    $result -> bindParam(":buscar", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":nomePessoa", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":identidadePessoa", $Buscar, PDO::PARAM_STR);
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

    function VerificarCurso($Valor = NULL , $conexao)
    {
        
        // if ( @$Admin != NULL):

            if(@$conexao){

                $query = "SELECT * FROM tb_curso WHERE curso = :valor LIMIT 1 ";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":valor", $Valor, PDO::PARAM_STR);;
               
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        // endif;

        return FALSE;
    }

    function RecoverCurso($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_curso SET estado_curso = 1, id_admin = :admin WHERE estado_curso = 0 AND id_curso = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarCurso( $Id, NULL, $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddCurso($Curso = NULL , $Admin = NULL, $conexao)
    {
        
        if ( @$Curso != NULL & @$Admin != NULL):

            if(@$conexao){

                $Exists = VerificarCurso($Curso , $conexao);
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_curso === "0"):
                        
                        $result = RecoverCurso($dados->id_curso , $Admin , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:

                    $query = "INSERT INTO tb_curso VALUES (DEFAULT,:curso,:admin, NOW(), DEFAULT)";
                    $query = "INSERT INTO tb_curso VALUES (DEFAULT,:curso,:admin, NOW(), 1)";
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":curso", $Curso, PDO::PARAM_STR);
                    $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        $result = BuscarCurso( $conexao->lastInsertId(),NULL, $Admin, $conexao);
                        return $result;
                    }
                    
                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteCurso($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_curso SET estado_curso = 0 WHERE estado_curso = 1 AND id_curso = :id";
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

    function UpdateCurso($Id = NULL, $Curso = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Curso != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_curso SET curso = :curso, id_admin = :admin WHERE estado_curso = 1 AND id_curso = :id AND curso != :curso";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":curso", $Curso, PDO::PARAM_STR);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarCurso($Id,NULL, $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }


    
    if ( in_array(DecodificarTexto($pagina) ,["formcurso","viewcursos"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddCurso($curso,$admin,$conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteCurso($id_d,$admin,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateCurso($id, $curso, $admin ,$conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverCurso($id, $admin ,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarCurso($id,$buscar, $admin, $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
