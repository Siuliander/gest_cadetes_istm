<?php require_once("./funcoes/Actions_Aluno.php"); ?>

<?php

    $result = BuscarAluno($id , NULL , $buscar, $admin, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Cadetes</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
				<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
                <li><a href="?pg=<?php echo CodificarTexto('formaluno');?>" >Adicionar</a></li>
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
                                                <th class="text-center">NOME</th>
                                                <th class="text-center">B.I./PASSAPORTE</th>
                                                <th class="text-center">SEXO</th>
                                                <th class="text-center">SANGUE</th>
                                                <th class="text-center">CURSO</th>
                                                <th class="text-center">DATA INSCRIÇÃO</th>
                                                <th class="text-center">VISUALIZAR</th>
												<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
													<th class="text-center" colspan="3">Acção</th>
												<?php elseif( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2]) ):?>
													<th class="text-center" colspan="1">Acção</th>
												<?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> sexo); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> sangue); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> curso); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_aluno); ?></td>
												
												
												
												<?php if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2]) ):?>
													<td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('view');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_aluno)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
                                                    </td>
													
                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('formmatricula');?>&id_a=<?php echo ProtegeTexto(base64_encode(@$row-> id_aluno)); ?>&id_c=<?php echo ProtegeTexto(base64_encode(@$row-> id_curso)); ?>&btn=<?php echo CodificarTexto('matricula');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-check"></i></a>
                                                    </td>
                                                    
                                                    <td>
                                                        <a href="<?php echo '?pg='.CodificarTexto('formaluno').'&id='.ProtegeTexto(base64_encode(@$row-> id_aluno)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewalunos');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_aluno)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
                                                    </td>
													
												<?php elseif( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [2]) ):?>
													<td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('view');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_aluno)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
                                                    </td>
												<?php endif; ?>
												
                                                    

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