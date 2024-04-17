<?php
	
	$result = NULL;
    $linha = NULL;
	$identidade = 0;
	$aluno_cookie = NULL ;
	
	
	if( isset($nivel_cookie) & @$nivel_cookie == '3' & isset( $_SESSION['id'] )):
		$aluno_cookie = $_SESSION['identidade'] ;
	endif;
	
	//var_dump($aluno_cookie);
	// $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;
	
	if( isset( $aluno_cookie ) & $aluno_cookie != NULL ):
		$identidade = $aluno_cookie;
	else:
		$identidade = ( isset($_POST["identidade"]) ? $_POST["identidade"] : (isset($_GET["identidade"]) ? $_GET["identidade"] : NULL) );
	endif;
    
	
	if( @$identidade != NULL):
        $query = "SELECT * FROM tb_matricula matricula

				JOIN tb_aluno aluno
				ON aluno.id_aluno = matricula.id_aluno

				JOIN tb_pessoa pessoa
				ON pessoa.id_pessoa = aluno.id_pessoa

				JOIN tb_curso curso
				ON curso.id_curso = aluno.id_curso

				WHERE 
					identidade_pessoa = :identidade LIMIT 1";

		$result = @$conexao->prepare(@$query);
		
		$result -> bindParam(":identidade", $identidade, PDO::PARAM_STR);

		$result->execute(); 

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
	
	function turmas($Id_aluno,$conexao)
	{
		 $query = "SELECT DISTINCT(turma.id_turma_curso), turma FROM tb_matricula matricula

					JOIN tb_turma_curso turma
					ON turma.id_turma_curso = matricula.id_turma_curso

					WHERE id_aluno = :id";

		$result = @$conexao->prepare(@$query);
		
		$result -> bindParam(":id", $Id_aluno, PDO::PARAM_STR);

		$result->execute(); 

        if ((@$result->rowCount() > 0)):  
            return $result;
        endif;
	}
	
 
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Consultar<small> Notas Do Cadetes</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
				<?php if ( @$linha ):?>
					<?php if ( isset( $aluno_cookie ) & $aluno_cookie != NULL ):?>
						<li><a href="#" ></a></li>
					<?php else:?>
						<li><a href="?pg=<?php echo CodificarTexto('formnota');?>" >Nova Consulta</a></li>
					<?php endif;?>
				<?php else:?>
					<li><a href="#" ></a></li>
				<?php endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewnotas'); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formnota" name="pg">
                                    </div>
									
									<?php if (!@$linha):  ?>
										<div class="form-group label-floating">
											<label class="control-label"><?php echo (@$linha) ? 'B.I./Passaporte Do Cadete' : 'B.I./Passaporte Do Cadete'; ?></label>
											<input class="form-control" type="identidade" name="identidade" required>
										</div>
									<?php endif; ?>
									
									<?php if (@$linha):  ?>
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID</label>
                                                <input hidden class="form-control" type="text" value="<?php echo ($linha->id_matricula); ?>" name="matricula">
                                            </div>
											
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID Cadete</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_aluno); ?>" name="aluno">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">Cadete</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">B.I./Passaporte Do Cadete</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->identidade_pessoa : NULL; ?>">
                                            </div>
											
											<div class="form-group label-floating">
												<label class="control-"><?php echo (@$linha) ? 'Curso' : 'Curso'; ?></label>
												<select class="form-control" type="select" name="curso" required>
													<option selected value="<?php echo $linha->id_curso ;?>"> <?php echo $linha->curso ;?></option>
												</select>
											</div>
											
											<div class="form-group label-floating">
												<label class="control-"><?php echo (@$linha) ? 'Turma' : 'Turma'; ?></label>
												<select class="form-control" type="select" name="turma" required>
												<option value="">Selecione ... </option>
													<?php $Turmas = turmas($linha->id_aluno , $conexao); ?>
													<?php if($Turmas):while( $turma = $Turmas->fetchobject() ):?>
														<option selected value="<?php echo $turma->id_turma_curso ;?>"> <?php echo $turma->turma ;?></option>
													<?php endwhile; endif; ?>
												</select>
											</div>
                                            
                                    <?php  endif;?>
									
                                
                                    <p class="text-center">
                                        <button class="btn btn-reset btn-raised btn-sm" type="reset" name="btn"><i class="zmdi zmdi-reset"></i> Limpar</button>
										<button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('query');?>"><i class="zmdi zmdi-floppy"></i> Buscar Cadete</button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

