<?php
require_once("./includes/Protetions.php");
require_once("./includes/Erros.php");
require_once("./includes/conexao.php");
?>

<?php
	session_start();
	
	if ( isset ( $_SESSION['id'] ) ) :
	// var_dump( $_SESSION );
		 header( "location:index.php");
	endif;

	$btn =  base64_decode( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

	$identidade =  ( isset($_POST["identidade"]) ? $_POST["identidade"] : (isset($_GET["identidade"]) ? $_GET["identidade"] : NULL) );
	$senha =  ( isset($_POST["senha"]) ? $_POST["senha"] : (isset($_GET["senha"]) ? $_GET["senha"] : NULL) );
	$nivel =  ( isset($_POST["nivel"]) ? $_POST["nivel"] : (isset($_GET["nivel"]) ? $_GET["nivel"] : NULL) );
   
    $result = NULL;
    $linha = NULL;
    
    function Log_In($Identidade = NULL , $Senha = NULL, $Nivel = NULL, $conexao)
    {
        
        if(@$Identidade != NULL && @$Senha != NULL && @$Senha != NULL):
            if(@$conexao){
                
				$query = "";
				
				if( $Nivel == '1' ):
					$query = "select * from tb_admin as admin
						join tb_pessoa as pessoa on pessoa.id_pessoa = admin.id_pessoa
						where estado_admin = 1 AND senha_admin = md5(:senha) AND identidade_pessoa = :identidade LIMIT 1";
				elseif( $Nivel == '2' ):
					$query = "select * from tb_docente as docente
						join tb_pessoa as pessoa on pessoa.id_pessoa = docente.id_pessoa
						where estado_docente = 1 AND senha_docente = md5(:senha) AND identidade_pessoa = :identidade LIMIT 1";
				elseif( $Nivel == '3' ):
					$query = "select * from tb_aluno as aluno
						join tb_pessoa as pessoa on pessoa.id_pessoa = aluno.id_pessoa
						where estado_aluno = 1 AND senha_aluno = md5(:senha) AND identidade_pessoa = :identidade LIMIT 1";
				endif;
				
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
                $result -> bindParam(":senha", $Senha, PDO::PARAM_STR);

                $result->execute(); 
					
                if($result->rowCount() > 0 )
                {
                   
					while( $linha = $result->fetchObject() ):
						if( $Nivel == '1' ):
							$_SESSION['id'] = $linha->id_admin;
							$_SESSION['nome'] = $linha->nome_pessoa;
							$_SESSION['identidade'] = $Identidade;
							$_SESSION['nivel'] = 1;
							$_SESSION['permissao'] = $linha->id_nivel;
						elseif( $Nivel == '2' ):
							$_SESSION['id'] = $linha->id_docente;
							$_SESSION['nome'] = $linha->nome_pessoa;
							$_SESSION['identidade'] = $Identidade;
							$_SESSION['nivel'] = 2;
							$_SESSION['disciplina1'] = $linha->id_disciplina; 
							$_SESSION['disciplina2'] = $linha->id_disciplina2;
							$_SESSION['disciplina3'] = $linha->id_disciplina3;
						elseif( $Nivel == '3' ):
							$_SESSION['id'] = $linha->id_aluno;
							$_SESSION['nome'] = $linha->nome_pessoa;
							$_SESSION['identidade'] = $Identidade;
							$_SESSION['nivel'] = 3;
						endif;
					endwhile;
					
					header( "location:index.php");
                    
                }
            }
        endif;

        return FALSE;
    }

    
    // if ( in_array(base64_decode($pagina) ,["login","logout"]) ):
        switch( $btn ):
            case 'add':
                Log_In($identidade , $senha, $nivel, $conexao);
                break;

            case 'delete':
                // LogOut($id_d,$conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    // endif;
?>

<?php
require_once("./includes/Authentication.php");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<title>Iniciar Sessão</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="./css/main.css">
</head>

<body class="cover" style="background-image: url(./assets/img/loginFonts.jpeg);">
	<form action="<?php $_SERVER ['PHP_SELF'] ;?>" method="post" autocomplete="off" class="full-box logInForm">
		<p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
		<p class="text-center text-muted text-uppercase">Iniciar Sessão no Sistema</p>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserId">Logar Como</label>
		  <select class="form-control" id="UserEmail" type="text" name="nivel">
				<option value="1" selected>Administração</option>
				<option value="2">Docente</option>
				<option value="3">Cadete</option>
		  </select>
		</div>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserEmail">Identidade</label>
		  <input class="form-control" id="UserEmail" type="text" name="identidade" required>
		  <p class="help-block">Identidade Do Usuário</p>
		</div>
		<div class="form-group label-floating">
		  <label class="control-label" for="UserPass">Senha</label>
		  <input class="form-control" id="UserPass" type="password" name="senha" required>
		  <p class="help-block">Digite a tua Senha</p>
		</div>
		
		<?php 
			if (isset($error_message)) 
			{
				echo "<p>$error_message</p>";
			} 
		?>
		<div class="form-group text-center">
			<button class="btn btn-raised btn-danger" type="submit" name="btn" value="<?php echo CodificarTexto('add');?>"><i class="zmdi zmdi-login"></i> Iniciar Sessão</button>
		</div>
		<p class="text-center">
			<button class="btn btn-reset btn-raised btn-sm" type="reset" name="btn"><i class="zmdi zmdi-reset"></i> Limpar</button>
		</p>
	</form>
	
	<!--====== Scripts -->
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/material.min.js"></script>
	<script src="./js/ripples.min.js"></script>
	<script src="./js/sweetalert2.min.js"></script>
	<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="./js/main.js"></script>
	<script>
		$.material.init();
	</script>
</body>
</html>