<?php

require_once("./includes/Limite_Data_Nascimento.php");
require_once("./includes/Protetions.php");
require_once("./includes/Erros.php");
require_once("./includes/conexao.php");
$pagina = @$_GET["pg"] != null ? @$_GET["pg"] : 'home' ;

require_once("./includes/Authentication.php");

	$permissao_cookie = @$_SESSION['permissao'] ;
	$nivel_cookie = @$_SESSION['nivel'] ;
	$nome_cookie = @$_SESSION['nome'] ;
	$identidade_cookie = @$_SESSION['identidade'] ;
	
	$Insered = FALSE;
	
	// var_dump( $identidade_cookie );

	if ( !isset ( $_SESSION['id'] ) ) :
		 header( "location:login.php");
	endif;
	
	$btn =  base64_decode( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

	function Log_out() // FINALIZAR UM LOGIN
	{ 
		session_destroy();
		header("location: login.php");
	}
	
	switch( $btn ):
            case 'deletelogin':
                Log_Out();
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
	<title>SISTEMA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="./css/main.css">
</head>
<body>
	<!-- SideBar -->
	<?php require_once("./includes/menuLateral.php"); ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<nav class="full-box dashboard-Navbar">
			<ul class="full-box list-unstyled text-right">
				<li class="pull-left">
					<a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
				</li>
			</ul>
		</nav>
		
		
		<?php 
			// Todas as Rotas contidas no Arquivo
			require_once("./includes/Rotas.php");
		?>
		
		
	</section>

	<!-- Notifications area -->
	

	<!-- Dialog help -->
	
	<!--====== Scripts -->
		<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/sweetalert2.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/material.min.js"></script>
	<script src="./js/ripples.min.js"></script>
	<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="./js/main.js"></script>
	<script>
		$.material.init();
	</script>
</body>
</html>