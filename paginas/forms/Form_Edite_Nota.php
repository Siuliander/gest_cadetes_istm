<?php
	$result = NULL;
    $linha = NULL;

	// $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;
    $id = ( isset($_POST["id"]) ? $_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) );
    
	
	if( @$id != NULL):
        $query = "SELECT 
					*
					FROM tb_nota AS nota
					JOIN tb_matricula AS matricula ON matricula.id_matricula = nota.id_matricula
					JOIN tb_aluno AS aluno ON aluno.id_aluno = matricula.id_aluno
					JOIN tb_pessoa AS pessoa ON pessoa.id_pessoa = aluno.id_pessoa
					JOIN tb_disciplina_turma AS turma ON turma.id_disciplina_turma = nota.id_disciplina_turma
					JOIN tb_disciplina AS disciplina ON disciplina.id_disciplina = turma.id_disciplina
					JOIN tb_curso AS curso ON curso.id_curso = turma.id_curso
				WHERE 
					estado_nota = 2 AND 
					id_nota = :id LIMIT 1";

		$result = @$conexao->prepare(@$query);
		
		$result -> bindParam(":id", $id, PDO::PARAM_STR);

		$result->execute(); 

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
	
 
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lançar<small> Notas Do Cadetes</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <?php if ( @$linha ):?>
					<li><a href="?pg=<?php echo CodificarTexto('formnota');?>" >Nova Consulta</a></li>
				<?php else:?>
					<li><a href="#" ></a></li>
				<?php endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
		   <?php if(@$linha): ?>
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewnotas'); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formeditenota" name="pg">
                                    </div>
									
									<div hidden class="form-group label-floating">
										<label hidden class="control-label">ID</label>
										<input hidden class="form-control" type="text" value="<?php echo ($linha->id_nota); ?>" name="id">
									</div>
											
									<div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="<?php echo ($linha->id_matricula); ?>" name="matricula">
                                    </div>
									
									<div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Identidade Do Cadete' : 'Identidade Do Cadete'; ?></label>
                                        <input class="form-control" disabled value="<?php echo (@$linha) ? $linha->identidade_pessoa : NULL; ?>">
                                    </div>
									
									<div class="form-group label-floating">
										<label class="control-label">Cadete</label>
										<input class="form-control" disabled value="<?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>">
									</div>
									
									<div class="form-group label-floating">
										<label class="control-label">Disciplina</label>
										<input class="form-control" disabled value="<?php echo (@$linha) ? $linha->disciplina : NULL; ?>">
									</div>
									
									<div class="form-group label-floating">
										<label class="control-label">Nota 1</label>
										<input class="form-control" type="number" min="0" max="20" name="nota1" value="<?php echo (@$linha) ? $linha->nota1 : NULL; ?>">
									</div>
									
									<div class="form-group label-floating">
										<label class="control-label">Nota 2</label>
										<input class="form-control" type="number" min="0" max="20" name="nota2" value="<?php echo (@$linha) ? $linha->nota2 : NULL; ?>">
									</div>
									
									<?php $media = ( ( @$linha-> nota1 + @$linha-> nota2) / 2); ?>
									
									<?php if( $media >= 7 ): ?>
										<div class="form-group label-floating">
											<label class="control-label">Exame</label>
											<input class="form-control" type="number" min="0" max="20" name="exame" value="<?php echo (@$linha) ? $linha->exame : NULL; ?>">
										</div>
									<?php endif; ?>
									
									<?php $mediaFinal = ( (@$linha-> exame * 0.6) + ($media * 0.4) ); ?>
									
									<?php if( $mediaFinal < 9 ): ?>
										<div class="form-group label-floating">
											<label class="control-label">Recurso</label>
											<input class="form-control" type="number" min="0" max="20" name="recurso" value="<?php echo (@$linha) ? $linha->recurso : NULL; ?>">
										</div>
									<?php endif; ?>
                                
                                    <p class="text-center">
										<a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewnotas');?>&id=<?php echo ProtegeTexto((@$linha-> id_aluno)) . '&matricula=' . ProtegeTexto((@$linha-> id_matricula)); ?>" class="btn btn-info btn-raised btn-sm">
											<i class="glyphicon glyphicon-arrow-left"></i> 
											Voltar
										</a>
										<?php if( isset($nivel_cookie) & in_array(@$nivel_cookie , [1,2]) ): ?>
											<button class="btn btn-reset btn-raised btn-sm" type="reset" name="btn"><i class="zmdi zmdi-reset"></i> Limpar</button>
											<button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('update');?>"><i class="zmdi zmdi-floppy"></i> Salvar Notas</button>
										<?php endif; ?>
									</p>
									
									
                                            
                                </form>
				<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

