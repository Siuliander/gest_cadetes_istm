<?php require_once("./funcoes/Actions_Curso.php"); ?>

<?php

    $result = BuscarCurso($id,$buscar, $admin, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Cursos</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
                <li><a href="?pg=<?php echo CodificarTexto('formcurso');?>" >Adicionar</a></li>
				<?php elseif( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [3]) ):?>
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
                                if (@$result and (@$result->rowCount() > 0)) {
                                ?>
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Curso</th>
                                                <th class="text-center">Data Insersão</th>
                                                <th class="text-center">Autor</th>
                                                <th class="text-center">Identidade Autor</th>
												<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
													<th class="text-center" colspan="2">Acção</th>
												<?php endif;?>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> curso); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_curso); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
													
													<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
														<td>
															<a href="<?php echo '?pg='.CodificarTexto('formcurso').'&id='.ProtegeTexto(base64_encode(@$row-> id_curso)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
														</td>

														<td>
															<a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewcursos');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_curso)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
														</td>
													<?php endif?>

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