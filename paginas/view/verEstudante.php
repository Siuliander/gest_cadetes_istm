<?php require_once("./funcoes/Actions_Aluno.php"); ?>

<?php
    $result = NULL;
    $linha = NULL;
	
	
    $id = base64_decode( isset($_POST["id"]) ? $_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) );
	
	if( @$id != NULL):
        $result = BuscarAluno($id , NULL , $buscar, $admin, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
?>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">Dados do <small> Cadete</small></h1>
    </div>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="col col-lg-H col-md-H col-sm-H haggy">
	
    <div class="panel panel-default panel-table">
		<div class="panel-body">
        <form class="form-horizontal" name="" method="POST" >
          <div class="form-group">
				<div class="col-sm-9">
				</div>
			  </div>
		  		
			<?php if(@$linha): ?>
				<div class="col-sm-12">
					<div class="form-group">
						<div class="col-sm-4">
							<label>Nome:</label> <?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>
						</div>

						<div class="col-sm-4">
							<label>B.I./Passaporte:</label> <?php echo (@$linha) ? $linha->identidade_pessoa : NULL; ?>
						</div>

						<div class="col-sm-4">
							<label>Data de Nascimento:</label> <?php echo (@$linha) ? $linha->nascimento_pessoa : NULL; ?>
						</div>
					</div>
					<hr>
				</div>
				
				<div class="col-sm-12">
					<div class="form-group">
						<div class="col-sm-4">
							<label>Sexo:</label> <?php echo (@$linha) ? $linha->sexo : NULL; ?>
						</div>
						
						<div class="col-sm-4">
							<label>Nacionalidade:</label> <?php echo (@$linha) ? $linha->nacionalidade : NULL; ?>
						</div>
						
						<div class="col-sm-4">
							<label>Sangue:</label> <?php echo (@$linha) ? $linha->sangue : NULL; ?>
						</div>
					</div>
					<hr>
			   </div>
			 
				<div class="col-sm-12">
					<div class="form-group">
						<div class="col-sm-4">
							<label>Contacto:</label> <?php echo (@$linha) ? $linha->telefone : NULL; ?>
						</div>
						
						<div class="col-sm-4">
							<label>Email:</label> <?php echo (@$linha) ? $linha->email : NULL; ?>
						</div>
					</div>
					<hr>
			   </div>
			  
			  <div class="col-sm-12">
				<div class="form-group">
						<div class="col-sm-4">
							<label>Curso:</label> <?php echo (@$linha) ? $linha->curso : NULL; ?>
						</div>
					</div>
					<hr>
				</div>
			<?php 
				else: 
					echo "<center> <h4>Nenhum Registo Foi Encontrado </h4></center>";
				endif; 
			?>
			
			 	<div class="col-sm-6 col col-xs-6 text-left">
				  <a href='?pg=<?php echo CodificarTexto('viewalunos');?>'>
					  <button type='button' onclick="location" class='btn  btn-info'>
						  <span class="glyphicon glyphicon-arrow-left"></span>
						  Voltar
					  </button>
				  </a>
				</div>
				
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
					<?php if(@$linha): ?>
						<div class="col-sm-6 col col-xs-6 text-right"> 
						  <a href='<?php echo '?pg='.CodificarTexto('formaluno').'&id='.ProtegeTexto(base64_encode(@$linha-> id_aluno)); ?>&btn=<?php echo CodificarTexto('editar');?>'>
							  <button type='button' class='btn btn-warning'>
								  <span class="glyphicon glyphicon-edit"></span>
								  Editar
							  </button>
						  </a>
						</div>	
					<?php endif; ?>
				<?php endif; ?>
				
			  </div>
			  
			</div>

			  </div>
			</form>
        </div>
		</div> 

