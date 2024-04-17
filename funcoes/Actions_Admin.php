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
    $nivel_acesso = ( isset($_POST["nivel"]) ? $_POST["nivel"] : (isset($_GET["nivel"]) ? $_GET["nivel"] : NULL) );
    
	$sexo_p = ( isset($_POST["sexo"]) ? $_POST["sexo"] : (isset($_GET["sexo"]) ? $_GET["sexo"] : NULL) );
    $email_p = ( isset($_POST["email"]) ? $_POST["email"] : (isset($_GET["email"]) ? $_GET["email"] : NULL) );
    $nacionalidade_p = ( isset($_POST["nacionalidade"]) ? $_POST["nacionalidade"] : (isset($_GET["nacionalidade"]) ? $_GET["nacionalidade"] : NULL) );
    $sangue_p = ( isset($_POST["sangue"]) ? $_POST["sangue"] : (isset($_GET["sangue"]) ? $_GET["sangue"] : NULL) );
    
    $id_pessoa = DecodificarTexto( isset($_POST["id_p_up"]) ? $_POST["id_p_up"] : (isset($_GET["id_p_up"]) ? $_GET["id_p_up"] : NULL) );
    $identidadeAntiga = DecodificarTexto( isset($_POST["idd_p_up"]) ? $_POST["idd_p_up"] : (isset($_GET["idd_p_up"]) ? $_GET["idd_p_up"] : NULL) );
    
    $admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;
    

    $result = NULL;
    $linha = NULL;
    $Insered = NULL;

    
    function BuscarAdmin($Id = NULL , $IdPessoa = NULL , $Buscar = NULL, $Admin = NULL, $conexao)
    {
        
        if(@$conexao){
            
            $query = "SELECT * FROM tb_admin AS admin 
                        JOIN tb_pessoa AS pessoa 
                            ON pessoa.id_pessoa = admin.id_pessoa 
                        JOIN tb_nivel AS nivel 
                            ON nivel.id_nivel = admin.id_nivel
						LEFT JOIN tb_sexo AS sexo 
							ON sexo.id_sexo = pessoa.id_sexo
						LEFT JOIN tb_sangue AS sangue 
							ON sangue.id_sangue = pessoa.id_sangue
						LEFT JOIN tb_nacionalidade AS nacionalidade
							ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
                        WHERE estado_admin = 1 
                            AND ( pessoa.nome_pessoa like :nomePessoa 
                            OR identidade_pessoa like :identidadePessoa 
                            OR nivel.nivel like :nivel ) ";
            
            if(@$Id != NULL ): 
                $query = "SELECT * FROM tb_admin AS admin 
                            JOIN tb_pessoa AS pessoa 
                                ON pessoa.id_pessoa = admin.id_pessoa 
                            JOIN tb_nivel AS nivel 
                                ON nivel.id_nivel = admin.id_nivel
						LEFT JOIN tb_sexo AS sexo 
							ON sexo.id_sexo = pessoa.id_sexo
						LEFT JOIN tb_sangue AS sangue 
							ON sangue.id_sangue = pessoa.id_sangue
						LEFT JOIN tb_nacionalidade AS nacionalidade
							ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
                            WHERE estado_admin = 1 
                            AND id_admin = :id LIMIT 1";
            elseif(@$IdPessoa != NULL ): 
                $query = "SELECT * FROM tb_admin WHERE id_pessoa = :idPessoa LIMIT 1";
            elseif(@$Id != NULL & @$IdPessoa != NULL): 
                $query = "SELECT * FROM tb_admin AS admin 
                            JOIN tb_pessoa AS pessoa 
                                ON pessoa.id_pessoa = admin.id_pessoa 
                            JOIN tb_nivel AS nivel 
                                ON nivel.id_nivel = admin.id_nivel
						LEFT JOIN tb_sexo AS sexo 
							ON sexo.id_sexo = pessoa.id_sexo
						LEFT JOIN tb_sangue AS sangue 
							ON sangue.id_sangue = pessoa.id_sangue
						LEFT JOIN tb_nacionalidade AS nacionalidade
							ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
                            WHERE estado_admin = 1 
                            AND id_admin = :id AND identidade_pessoa = :identidadePessoa LIMIT 1";
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
                $result -> bindParam(":nivel", $Buscar, PDO::PARAM_STR);
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

    

    function RecoverAdmin($Id = NULL, $Admin = NULL,$conexao)
    {
        if ( @$Id != NULL & @$Admin != NULL):
            
            if(@$conexao){

                $query = "UPDATE tb_admin SET estado_admin = 1, data_actualizacao_admin = NOW() WHERE estado_admin = 0 AND id_admin = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarAdmin($Id , NULL , NULL , $Admin , $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddAdmin($Nome = NULL , $Identidade = NULL , $Nivel = NULL, $Nascimento = NULL, $Telefone = NULL,$Email = NULL, $Sexo = NULL , $Nacionalidade = NULL , $Sangue = NULL, $Admin = NULL, $conexao)
    {
        
        if ( @$Nome != NULL & @$Identidade != NULL & @$Nivel != NULL & @$Admin != NULL):

            if(@$conexao)
            {

                $Pessoa = AddPessoa($Nome,$Identidade,$Nascimento,$Telefone,$Email, $Sexo, $Nacionalidade , $Sangue, $conexao);
                $Exists = BuscarAdmin(NULL, $Pessoa,NULL,$Admin,$conexao);
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_admin === "0"):
                        
                        $result = RecoverAdmin($dados->id_admin , $Admin , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:
                    
                    // $query = "INSERT INTO tb_admin VALUES (DEFAULT,:idPessoa,DEFAULT,NOW(), NOW(), DEFAULT)";
                    $query = "INSERT INTO tb_admin VALUES (DEFAULT,:idPessoa,:nivel,md5(1234),NOW(), NOW(), 1)";
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":idPessoa", $Pessoa, PDO::PARAM_INT);
                    $result -> bindParam(":nivel", $Nivel, PDO::PARAM_INT);
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

    function DeleteAdmin($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao)
            {
				$query = "UPDATE tb_admin SET estado_admin = 0, data_actualizacao_admin = NOW() WHERE estado_admin = 1 AND id_admin = :id";
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

    function UpdateAdmin($Id = NULL, $IdPessoa = NULL, $Identidade = NULL, $IdentidadeNova = NULL, $Nivel = NULL , $Nome = NULL ,  $Nascimento = NULL, $Telefone = NULL,$Email = NULL, $Sexo = 0 , $Nacionalidade = 0 , $Sangue = 0 , $Admin = NULL,$conexao)
    {
        
        if ( @$Id != NULL & @$IdPessoa != NULL & @$IdentidadeNova != NULL & @$Identidade != NULL & @$Nivel != NULL & @$Admin != NULL):

            if(@$conexao){

                $Exists = BuscarAdmin($Id, $IdPessoa, NULL, $Admin, $conexao);
                
                if($Exists):

                    $Pessoa =  UpdatePessoa($IdPessoa, $Nome, $Identidade , $IdentidadeNova , $Nascimento , $Telefone , $Email , $Sexo , $Nacionalidade , $Sangue ,$conexao);
    
                    $dados = $Exists->fetchObject();
                    
                    // if( $dados->estado_admin === "1"):
                        
                        $query = "UPDATE tb_admin SET data_actualizacao_admin = NOW(), id_nivel = :nivel WHERE estado_admin = 1 AND id_admin = :id AND id_pessoa = :idPessoa";
                        $result = @$conexao->prepare($query);
                        
                        $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                        $result -> bindParam(":idPessoa", $IdPessoa, PDO::PARAM_INT);
                        $result -> bindParam(":nivel", $Nivel, PDO::PARAM_INT);
                            
                        $result->execute();

                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                   //  endif;

                endif;

            }

        endif;

        return FALSE;
    }

    
    if ( in_array(DecodificarTexto($pagina) ,["formadmin","viewadmins"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddAdmin($nome_pessoa , $identidade_pessoa , $nivel_acesso , $nascimento_pessoa , $telefone_pessoa , $email_p,$sexo_p,$nacionalidade_p,$sangue_p, $admin , $conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteAdmin($id_d,$admin,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateAdmin($id , $id_pessoa , $identidadeAntiga , $identidade_pessoa , $nivel_acesso , $nome_pessoa ,  $nascimento_pessoa , $telefone_pessoa , $email_p,$sexo_p,$nacionalidade_p,$sangue_p, $admin , $conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverAdmin($id, $admin,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarAdmin($id , NULL , $buscar , $admin , $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
