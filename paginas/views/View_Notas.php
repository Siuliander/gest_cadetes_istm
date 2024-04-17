<?php require_once("./funcoes/Actions_Nota.php"); ?>

<?php
	$result = NULL;
    $linha = NULL;
	
	$matricula = ( isset($_POST["matricula"]) ? $_POST["matricula"] : (isset($_GET["matricula"]) ? $_GET["matricula"] : NULL) );
	$buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    
    if( @$matricula != NULL):
        $query = "SELECT * FROM tb_nota AS nota
					JOIN tb_disciplina_turma AS turma ON turma.id_disciplina_turma = nota.id_disciplina_turma
					JOIN tb_disciplina AS disciplina ON disciplina.id_disciplina = turma.id_disciplina
					WHERE estado_nota > 0 AND id_matricula = :matricula";
		
		if( @$buscar != NULL ):
			$query = $query . " AND disciplina = :disciplina "; 
		endif;

		$result = @$conexao->prepare(@$query);
		
		
		$result -> bindParam(":matricula", $matricula, PDO::PARAM_STR);
		
		if( @$buscar != NULL ):
			$buscar = "%" . $buscar . "%";
			$result -> bindParam(":disciplina", $buscar, PDO::PARAM_STR);
		endif;

		$result->execute(); 
		
    endif;
	
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Detalhes de<small> Notas</small></h1>
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
            
            <?php require_once("./includes/Form_Buscar.php"); ?>


            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">



                            <div class="table-responsive">
                                <?php
                                if ($result and ($result->rowCount() > 0)) {
                                ?>
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">DISCIPLINA</th>
                                                <th class="text-center">PROVA 1</th>
                                                <th class="text-center">PROVA 2</th>
                                                <th class="text-center">MÉDIA</th>
                                                <th class="text-center">EXAME</th>
                                                <th class="text-center">RECURSO</th>
                                                <th class="text-center">MÉDIA FINAL</th>
                                                <th class="text-center">RESULTADO</th>
												<?php if( isset($nivel_cookie) & in_array(@$nivel_cookie , [1,2]) ): ?>
													<th class="text-center">ACÇÃO</th>
												<?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php 
												// while ($row = @$result->fetchobject() ) { 
												foreach ($result->fetchall() as $row ) { 
											?>
											
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row['disciplina']); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row['nota1']); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row['nota2']); ?></td>
													
                                                    <td>
														<?php 
															$media = ( ( @$row['nota1'] + @$row['nota2']) / 2);
															echo $media;
														?>
													</td>
													
                                                    <td>
														<?php 
															if( $media < 7 ):
																echo '-'; 
															elseif( $media >= 7 ):
																$exame = 1;
																echo ProtegeTexto(@$row['exame']);
															endif;
														?>
													</td>
													
                                                    <td><?php echo ProtegeTexto(@$row['recurso']); ?></td>
													
													<td>
														<?php 
															$mediaFinal = 0 ;
															
															if( @$row['exame'] < 1 ):
																echo '-'; 
															elseif( @$row['exame'] >= 1 ):
																$mediaFinal = ( (@$row['exame'] * 0.6) + ($media * 0.4) );
																echo $mediaFinal;
															endif;
														?>
													</td>
													
                                                    <td>
														<?php 
														
															$exame = 0;
															$recurso = 0;
															$msg = "-";
															
															if( $media == 0 & @$row['recurso'] == 0 & $mediaFinal == 0 ):
																$recurso = 1;
																$msg = '-'; 
															elseif( $media < 7 & @$row['recurso'] == 0 & $mediaFinal == 0 ):
																$recurso = 1;
																$msg = 'recurso'; 
															elseif( $media >= 7 & $media < 14 & $mediaFinal == 0 ):
																$exame = 1;
																$msg = 'exame';
															elseif( $media >= 14 || $mediaFinal >= 10 || ( @$row['recurso'] >= 10 )):
																$msg = 'apto';
															else:
																$msg = 'n/apto';
															endif;
															
															Echo $msg ;
														?>
													</td>
													
													<?php if( isset($nivel_cookie) & in_array(@$nivel_cookie , [1,2]) ): ?>
													
														<?php if( @$row['estado_nota'] == "2" & !( $media >= 14 || $mediaFinal >= 10 ) ): ?>
															
															<?php if( in_array(@$permissao_cookie , [2,3]) ):?>
																<td>
																	<a href="<?php echo '?pg='.CodificarTexto('formeditenota').'&id='.ProtegeTexto((@$row['id_nota'])) . '&matricula=' . ProtegeTexto($matricula) ; ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
																</td>
															<?php elseif( (@$_SESSION['disciplina1'] == @$row['id_disciplina']) OR (@$_SESSION['disciplina2'] == @$row['id_disciplina']) OR (@$_SESSION['disciplina3'] == @$row['id_disciplina']) ):?>
																<td>
																	<a href="<?php echo '?pg='.CodificarTexto('formeditenota').'&id='.ProtegeTexto((@$row['id_nota'])) . '&matricula=' . ProtegeTexto($matricula) ; ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
																</td>
															<?php else: ?>
																<td>
																	<a href="#" class="btn btn-info btn-raised btn-xs"></a>
																</td>
															<?php endif;?>
															
														<?php else: ?>
															<?php if( in_array(@$permissao_cookie , [2]) ):?>
																<td>
																	<a href="<?php echo '?pg='.CodificarTexto('formeditenota').'&id='.ProtegeTexto((@$row['id_nota'])) . '&matricula=' . ProtegeTexto($matricula) ; ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
																</td>
															<?php else:?>
																<td>
																	<a href="#" class="btn btn-info btn-raised btn-xs"></a>
																</td>
															<?php endif; ?>
														<?php endif; ?>
														
													<?php endif; ?>
                                                </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else {
                                    echo "<center> <h4>Nenhum Registo Foi Encontrado </h4></center>";
                                } ?>

                            </div>



                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>