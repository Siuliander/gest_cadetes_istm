<?php 
    @session_start();

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $identidade =  ( isset($_POST["identidade"]) ? $_POST["identidade"] : (isset($_GET["identidade"]) ? $_GET["identidade"] : NULL) );
    $senha =  ( isset($_POST["senha"]) ? $_POST["senha"] : (isset($_GET["senha"]) ? $_GET["senha"] : NULL) );
    $acesso =  ( isset($_POST["nivel"]) ? $_POST["nivel"] : (isset($_GET["nivel"]) ? $_GET["nivel"] : NULL) );

    
    function Logout() // FINALIZAR UM LOGIN
    { 
        session_destroy();
        header("location: login.php");
    }
    
    function DadoAuth( $Dados = NULL , $Permissao = NULL )
    {
        $_SESSION["permissao"] = $Permissao;
        
        $_SESSION["admin"] = $Dados-> id_admin;
        $_SESSION["nivel"] = $Dados-> nivel;
        
        $_SESSION["id"] = $Dados-> id_admin;
        $_SESSION["nome"] = $Dados-> nome_pessoa;
        $_SESSION["identidade"] = $Dados-> identidade_pessoa;
        
        $_SESSION["perfil"] = $Dados-> perfil;
        $_SESSION["estado"] = $Dados-> estado_admin;
    }
        
    function Login($Identidade = NULL , $Senha = NULL, $Nivel = NULL, $conexao) // INICIALIZAR UM LOGIN
    { 
        if(@$Identidade != NULL && @$Senha != NULL):
            if(@$conexao){
                
                
                $query = "";
                
                if( $Permissao === "1" ):
                    $query = "SELECT * FROM tb_admin AS admin 
                                JOIN tb_pessoa AS pessoa 
                                 ON pessoa.id_pessoa = admin.id_pessoa 
                                JOIN tb_nivel AS nivel 
                                 ON nivel.id_nivel = admin.id_nivel
                                WHERE estado_admin = 1 
                                 AND identidade_pessoa = :identidade AND senha_admin = :senha LIMIT 1";
                elseif( $Permissao === "2" ):
                    
                elseif( $Permissao === "3" ):
                    
                endif;                
                
                $result = @$conexao->prepare(@$query);

                if(   in_array ($Permissao , ["1" , "2", "3" ]) ):
                    $result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
                    $result -> bindParam(":senha", $Senha, PDO::PARAM_STR);   
                endif;
                
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    $dados = $result->fetchObject();
                    DadoAuth( $dados );
                    return TRUE;
                }
            }
        endif;

        Logout();
        return FALSE;
        
    }


    function Authentication($Identidade = NULL, $conexao) 
    { 
        if(@$Identidade != NULL ):
            if(@$conexao){
                
                $query = "SELECT * FROM tb_admin AS admin 
                            JOIN tb_pessoa AS pessoa 
                                ON pessoa.id_pessoa = admin.id_pessoa 
                            JOIN tb_nivel AS nivel 
                                ON nivel.id_nivel = admin.id_nivel
                            WHERE estado_admin = 1 
                            AND identidade_pessoa = :identidade LIMIT 1";
                            
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    $dados = $result->fetchObject();
                    DadoAuth( $dados );
                    return TRUE;
                }
            }
        endif;

        
        return FALSE;
        
    }
    
    function Auth($Conexao) // VERIFICA E ACTUALIZA O LOGIN ACTIVO
    { 
        $Identidade = ISSET( $_SESSION['identidade'] ) ? $_SESSION['identidade'] : NULL;
        
        $auth = Authentication($Identidade , $Conexao);
        
        if( !$auth ):
          Logout();
        endif;
    }

    
    // if ( in_array(DecodificarTexto($pagina) ,["login","logout"]) ):
        switch( $btn ):
            case 'addLogin':
                $auth = Login($identidade , $senha, $conexao);
                if(!$auth): 
                    header("location: login.php"); 
                else: 
                    header("location: index.php"); 
                endif;
                break;

            case 'deleteLogin':
                Logout();
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
   // endif;

    //Login('admin' , md5(1234), $conexao);
    
    

?>