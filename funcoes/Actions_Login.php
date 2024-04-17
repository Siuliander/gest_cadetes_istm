<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

   $identidade =  ( isset($_POST["identidade"]) ? $_POST["identidade"] : (isset($_GET["identidade"]) ? $_GET["identidade"] : NULL) );
   $senha =  ( isset($_POST["senha"]) ? $_POST["senha"] : (isset($_GET["senha"]) ? $_GET["senha"] : NULL) );
   $nivel =  ( isset($_POST["nivel"]) ? $_POST["nivel"] : (isset($_GET["nivel"]) ? $_GET["nivel"] : NULL) );
   
  
    $result = NULL;
    $linha = NULL;

    
    function LogIn($Identidade = NULL , $Senha = NULL, $Nivel = NULL, $conexao)
    {
        
        if(@$Identidade != NULL && @$Senha != NULL && @$Senha != NULL):
            if(@$conexao){
                
				$query = "";
				
				if( $Nivel == '1' ):
					$query = "select * from tb_admin as admin
						join tb_pessoa as pessoa on pessoa.id_pessoa = admin.id_pessoa
						where senha_admin = md5(:senha) AND identidade_pessoa = :identidade LIMIT 1";
				elseif( $Nivel == '2' ):
					$query = "select * from tb_docente as docente
						join tb_pessoa as pessoa on pessoa.id_pessoa = docente.id_pessoa
						where senha_docente = md5(:senha) AND identidade_pessoa = :identidade LIMIT 1";
				elseif( $Nivel == '3' ):
					$query = "select * from tb_aluno as aluno
						join tb_pessoa as pessoa on pessoa.id_pessoa = aluno.id_pessoa
						where senha_aluno = md5(:senha) AND identidade_pessoa = :identidade LIMIT 1";
				endif;
				  
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
                $result -> bindParam(":senha", $Senha, PDO::PARAM_STR);

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    
					while( $dados = $result->fetchObject() ):
						if( $Nivel == '1' ):
							$_SESSION['id'] = $dados->id_admin;
							$_SESSION['nome'] = $dados->nome_pessoa;
							$_SESSION['nivel'] = 1;
							$_SESSION['permissao'] = $dados->id_nivel;
						elseif( $Nivel == '2' ):
							$_SESSION['id'] = $dados->id_docente;
							$_SESSION['nome'] = $dados->nome_pessoa;
							$_SESSION['nivel'] = 2;
						elseif( $Nivel == '3' ):
							$_SESSION['id'] = $dados->id_aluno;
							$_SESSION['nome'] = $dados->nome_pessoa;
							$_SESSION['nivel'] = 3;
						endif;
					endwhile;
                    
                }
            }
        endif;

        return FALSE;
    }

    
    if ( in_array(DecodificarTexto($pagina) ,["login","logout"]) ):
        switch( $btn ):
            case 'add':
                LogIn($identidade , $senha, $nivel, $conexao);
                break;

            case 'delete':
                // LogOut($id_d,$conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
