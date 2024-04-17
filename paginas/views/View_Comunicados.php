<?php require_once("./funcoes/Actions_Comunicado.php"); ?>

<?php

    $result = BuscarComunicado($id,$buscar, 1, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Comunicados</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('formcomunicado');?>" >Adicionar</a></li>
            </ul>

            
            <?php require_once("./includes/Form_Buscar.php"); ?>


            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">



                            <div class="table-responsive">
                                <?php
                                if (@$result and (@$result->rowCount() > 0)) {
                                ?>
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Comunicado</th>
                                                <th class="text-center">Descrição</th>
                                                <th class="text-center">Data Comunicado</th>
                                                <th class="text-center">Autor</th>
                                                <th class="text-center">Identidade Autor</th>
                                                <th class="text-center">Visualizar</th>
												
													<?php if( isset($nivel_cookie) & in_array(@$nivel_cookie , [1]) ): ?>
													
                                                <th class="text-center" colspan="2">Acção</th>
												<?php endif;?>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td>
														<?php 
															$texto = ProtegeTexto(@$row-> titulo_comunicado);
															$limite = 30;
															$tamanho = strlen( $texto );

															if( $tamanho <= $limite):
																echo $texto;
															else:
																echo trim(substr($texto,0,$limite)) . " ...";
															endif;
														?>
													</td>
                                                    <td>
														<?php 
															$texto = ProtegeTexto(@$row-> descricao_comunicado);
															$limite = 30;
															$tamanho = strlen( $texto );

															if( $tamanho <= $limite):
																echo $texto;
															else:
																echo trim(substr($texto,0,$limite)) . " ...";
															endif;
														?>
													</td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_comunicado); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
													
                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewComunicado');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_comunicado)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
                                                    </td>
													
													<?php if( isset($nivel_cookie) & in_array(@$nivel_cookie , [1]) ): ?>
													
                                                    <td>
                                                        <a href="<?php echo '?pg='.CodificarTexto('formcomunicado').'&id='.ProtegeTexto(base64_encode(@$row-> id_comunicado)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewcomunicados');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_comunicado)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
                                                    </td>
													<?php endif;?>

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