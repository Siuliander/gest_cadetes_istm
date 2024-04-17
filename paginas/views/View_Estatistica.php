<?php require_once("./funcoes/Actions_Admin.php"); ?>
<?php require_once("./funcoes/Actions_Disciplina.php"); ?>

<?php require_once("./funcoes/Actions_Curso.php"); ?>
<?php require_once("./funcoes/Actions_Turma.php"); ?>

<?php
    //
    // BUSCANDO OS REGISTOS PARA PODER APRESENTAR OS TOTAL DE CADA 
    //
    $adminLogado = 1 ;
    $Admins = BuscarAdmin(NULL , NULL , NULL , $adminLogado , $conexao);
    $Cursos = BuscarCurso(NULL,NULL, $adminLogado, $conexao);
    $Disciplinas = Buscar(NULL , NULL , $adminLogado , $conexao);

    $TurmasInscriacao = BuscarTurma($id,$buscar, 3,  $adminLogado, $conexao);
    $TurmasActivas =    BuscarTurma($id,$buscar, 2,  $adminLogado, $conexao);
    $TurmasEncerradas = BuscarTurma($id,$buscar, 1,  $adminLogado, $conexao);
    $Turmas =           BuscarTurma(NULL,NULL, NULL, $adminLogado, $conexao);

?>

<!-- Content page -->

<!-- Content page -->
    <div class="container-fluid">
        <div class="page-header">
            <h1 class="text-titles">Sistema  De Gestão - <small>Academia da Força Aérea</small></h1>
        </div>
    </div>
	
    <div class="full-box text-center" 
		style="
			padding: 30px 10px;
			height:600px;
			background:url('assets/img/background.png');
			background-repeat:no-repeat;
			background-position:center;
			background-size:300px 300px;
			"
	>
        
		<?php if( isset($nivel_cookie) & in_array(@$nivel_cookie , [1]) ): ?>
		
			<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1]) ):?>
				<a href="?pg=<?php echo CodificarTexto('viewadmins');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Administrador
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-account"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo  ($Admins) ? $Admins->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a>
			<?php endif;?>
			
			<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2,3]) ):?>
					
				<a href="?pg=<?php echo CodificarTexto('viewcursos');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Curso
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-book"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo ($Cursos) ? $Cursos->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a>    

				<a href="?pg=<?php echo CodificarTexto('viewturmas');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Turma
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-book"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo ($Turmas) ? $Turmas->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a> 

				<a href="?pg=<?php echo CodificarTexto('viewturmas');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Turma P/ Inscrição
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-book"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo ($TurmasInscriacao) ? $TurmasInscriacao->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a> 

				<a href="?pg=<?php echo CodificarTexto('viewturmas');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Turma Activas
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-book"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo ($TurmasActivas) ? $TurmasActivas->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a> 

				<a href="?pg=<?php echo CodificarTexto('viewturmas');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Turma Encerradas
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-book"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo ($TurmasEncerradas) ? $TurmasEncerradas->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a> 

				<a href="?pg=<?php echo CodificarTexto('viewdisciplinas');?>">
					<article class="full-box tile">
						<div class="full-box tile-title text-center text-titles text-uppercase">
							Disciplina
						</div>
						<div class="full-box tile-icon text-center">
							<i class="zmdi zmdi-book"></i>
						</div>
						<div class="full-box tile-number text-titles">
							<p class="full-box"><?php echo ($Disciplinas) ? $Disciplinas->rowCount() : 0 ;  ?></p>
							<small>Registros</small>
						</div>
					</article>
				</a>
			
			<?php endif;?>
		<?php else:?>
			<strong>
				<h1 style="font-style:bold;font-weight:24;font-size:45px;--wibkit-linear-gradient(#000dff,#jjddma)"> SEJA BEM-VINDO AO SISTEMA <i class="zmdi zmdi-computer"></i> </h1>
			</strong>
		<?php endif;?>

    </div>
	
