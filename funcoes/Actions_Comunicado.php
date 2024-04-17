<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    $titulo =  ( isset($_POST["titulo"]) ? $_POST["titulo"] : (isset($_GET["titulo"]) ? $_GET["titulo"] : NULL) );
    $descricao =  ( isset($_POST["descricao"]) ? $_POST["descricao"] : (isset($_GET["descricao"]) ? $_GET["descricao"] : NULL) );
    
	$admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;
    $Insered = NULL;

    //var_dump($id);
    
    function BuscarComunicado($Id = NULL , $Buscar = NULL , $Admin = NULL, $conexao)
    {
        
        if ( @$Admin != NULL):

            if(@$conexao){

                $query = "SELECT * FROM tb_comunicado AS comunicado 
                JOIN tb_admin admin 
                    ON admin.id_admin = comunicado.id_admin 
                JOIN tb_pessoa pessoa 
                    ON pessoa.id_pessoa = admin.id_pessoa 
                WHERE estado_comunicado = 1 
                    AND (comunicado.titulo_comunicado LIKE :titulo 
                    OR comunicado.descricao_comunicado LIKE :descricao
                    OR pessoa.nome_pessoa like :nomePessoa 
                    OR identidade_pessoa like :identidadePessoa ) ";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_comunicado AS comunicado 
                                JOIN tb_admin admin 
                                    ON admin.id_admin = comunicado.id_admin 
                                JOIN tb_pessoa pessoa 
                                    ON pessoa.id_pessoa = admin.id_pessoa 
                                WHERE estado_comunicado = 1  
                                    AND id_comunicado = :id LIMIT 1";
                endif;
                
                $result = @$conexao->prepare(@$query);
                
                if(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                else:
                    $Buscar = "%".$Buscar."%";
                    $result -> bindParam(":titulo", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":descricao", $Buscar, PDO::PARAM_STR);
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

    function Verificar($Valor = NULL , $conexao)
    {
        
       
            if(@$conexao){

                $query = "SELECT * FROM tb_comunicado WHERE titulo = :valor LIMIT 1 ";
                
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

    function RecoverComunicado($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_comunicado SET estado_comunicado = 1, id_admin = :admin WHERE estado_comunicado = 0 AND id_comunicado = :idUPDATE tb_comunicado SET estado_comunicado = 0 WHERE estado_comunicado = 1 AND id_comunicado = :id  LIMIT 1";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarComunicado( $Id, NULL, $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddComunicado($Titulo = NULL , $Descricao = NULL, $Admin = NULL, $conexao)
    {
        
        if ( @$Titulo != NULL & @$Admin != NULL):

            if(@$conexao){

                $Exists = Verificar(NULL , False);
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_comunicado === "0"):
                        
                        $result = Recover($dados->id_comunicado , $Admin , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:

                    $query = "INSERT INTO tb_comunicado 
                                (id_comunicado, titulo_comunicado, descricao_comunicado, data_comunicado, estado_comunicado, id_admin) 
                            VALUES 
                                (DEFAULT, :titulo, :descricao, NOW(), DEFAULT, :admin );";


                    $query = "INSERT INTO tb_comunicado 
                                (id_comunicado, titulo_comunicado, descricao_comunicado, data_comunicado, estado_comunicado, id_admin) 
                            VALUES 
                                (DEFAULT, :titulo, :descricao, NOW(), 1, :admin );";
                    
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":titulo", $Titulo, PDO::PARAM_STR);
                    $result -> bindParam(":descricao", $Descricao, PDO::PARAM_STR);
                    $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        $result = BuscarComunicado( $conexao->lastInsertId(),NULL, $Admin, $conexao);
                        return $result;
                    }
                    
                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteComunicado($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_comunicado SET estado_comunicado = 0 WHERE estado_comunicado = 1 AND id_comunicado = :id  LIMIT 1";
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

    function UpdateComunicado($Id = NULL, $Titulo = NULL , $Descricao = NULL, $Admin = NULL,$conexao)
    {

        if ( @$Titulo != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_comunicado SET titulo_comunicado = :titulo, descricao_comunicado = :descricao, data_comunicado = NOW(), id_admin = :admin WHERE estado_comunicado = 1 AND id_comunicado = :id LIMIT 1";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":titulo", $Titulo, PDO::PARAM_STR);
                $result -> bindParam(":descricao", $Descricao, PDO::PARAM_STR);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarComunicado($Id,NULL, $Admin, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }


    
    if ( in_array(DecodificarTexto($pagina) ,["formcomunicado","viewcomunicados"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddComunicado($titulo,$descricao,$admin,$conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteComunicado($id_d,$admin,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateComunicado($id, $titulo, $descricao, $admin ,$conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverComunicado($id, $admin ,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarComunicado($id,$buscar, $admin, $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
