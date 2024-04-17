<?php require_once("./funcoes/Actions_Militar.php"); ?>

<?php
    $result = NULL;
    $linha = NULL;
	
	
    $id = base64_decode( isset($_POST["id"]) ? $_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) );
	
	if( @$id != NULL):
        $result = BuscarMilitar($id, NULL, NULL, NULL , $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;

?>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">Detalhes do <small> Militar</small></h1>
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
							<label>NIP:</label> <?php echo (@$linha) ? $linha->nip : NULL; ?>
						</div>
						<div class="col-sm-4">
							<label>Data Da Corporação:</label> <?php echo (@$linha) ? $linha->data_corporacao : NULL; ?>
						</div>
						<div class="col-sm-4">
							<label>Patente:</label> <?php echo (@$linha) ? $linha->patente : NULL; ?>
						</div>
					</div>
					<hr>
				</div>
				
				  <div class="col-sm-12">
					<div class="form-group">
						<div class="col-sm-4">
							<label>Ramo:</label> <?php echo (@$linha) ? $linha->ramo : NULL; ?>
						</div>
						<div class="col-sm-4">
							<label>Quadro:</label> <?php echo (@$linha) ? $linha->quadro : NULL; ?>
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
				  <a href='?pg=<?php echo CodificarTexto('viewmilitares');?>'>
					  <button type='button' onclick="location" class='btn  btn-info'>
						  <span class="glyphicon glyphicon-arrow-left"></span>
						  Voltar
					  </button>
				  </a>
				</div>
				
				<?php if(@$linha): ?>
					<div class="col-sm-6 col col-xs-6 text-right"> 
					  <a href='<?php echo '?pg='.CodificarTexto('formmilitar').'&id='.ProtegeTexto(base64_encode(@$linha-> id_militar)); ?>&btn=<?php echo CodificarTexto('editar');?>'>
						  <button type='button' class='btn btn-warning'>
							  <span class="glyphicon glyphicon-edit"></span>
							  Editar
						  </button>
					  </a>
					</div>	
				<?php endif; ?>
				
				
			  </div>
			  
			</div>

			  </div>
			</form>
        </div>
		</div> 

