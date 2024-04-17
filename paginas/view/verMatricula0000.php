<?php require_once("./funcoes/Actions_Matricula.php"); ?>

<?php
    $result = NULL;
    $linha = NULL;
	
    $id = ( isset($_POST["id"]) ? $_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) );
	
	if( @$id != NULL):
        $result = BuscarMatriculados($id,null, null, $buscar, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
?>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Detalhes da <small> Matrícula</small></h1>
    </div>
</div>

<div class="container-fluid">
<div class="row-fluid">
<div class="col col-lg-H col-md-H col-sm-H haggy">
	
    <div class="panel panel-default panel-table">
		<div class="panel-body">
        <form class="form-horizontal" name="cadastrarEstudante" method="POST" >
          <div class="form-group">
				<div class="col-sm-9">
				</div>
			  </div>
		  		
			<div class="col-sm-12">
				<div class="form-group">
					<div class="col-sm-4">
						<label>Nome:</label> <?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>
					</div>

					<div class="col-sm-4">
						<label>B.I./Passaporte:</label> <?php echo (@$linha) ? $linha->identidade_pessoa : NULL; ?>
					</div>

					<div class="col-sm-4">
						<label>Data de Nascimento:</label> <?php echo (@$linha) ? $linha->data_nascimento : NULL; ?>
					</div>
				</div>
				<hr>
			</div>
         
          	<div class="col-sm-12">
				<div class="form-group">
					<div class="col-sm-4">
						<label>Contacto:</label> <?php echo 'contacto';?>
					</div>
				</div>
				<hr>
		   </div>
          
          <div class="col-sm-12">
			<div class="form-group">
					<div class="col-sm-4">
						<label>Curso:</label> <?php echo 'curso'?>
					</div>
					<div class="col-sm-4">
						<label>Ano:</label> <?php echo 'ano'?>
					</div>
					<div class="col-sm-4">
						<label>Turma:</label> <?php echo 'nomeTurma'?>
					</div>
				</div>
				<hr>
			</div>
			
			
			 	<div class="col-sm-6 col col-xs-6 text-left">
				  <button type='button' onclick="location" class='btn  btn-info'><span class="glyphicon glyphicon-arrow-left"></span>Voltar</button>
				</div>
				<div class="col-sm-6 col col-xs-6 text-right"> 
				  <a href='estudanteeditar.php?id=<?php echo @$id; ?>'><button type='button' class='btn btn-warning'><span class="glyphicon glyphicon-edit"></span> Editar</button></a>
				</div>	
				
			  
			  
			  </div>
			  
			</div>

			  </div>
			</form>
        </div>
		</div> 

