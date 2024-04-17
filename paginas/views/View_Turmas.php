<?php require_once("./funcoes/Actions_Turma.php"); ?>

<?php

    $result = BuscarTurma($id,$buscar, NULL,  $admin, $conexao);
    
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Turmas</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('formturma');?>" >Adicionar</a></li>
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
                                                <th class="text-center">Turma</th>
                                                <th class="text-center">Inicio</th>
                                                <th class="text-center">Ano</th>
                                                <th class="text-center">Curso</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Data Criação</th>
                                                <th class="text-center" colspan="3">Acção</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> turma); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> ano_inicio_turma); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> ano); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> curso); ?></td>
                                                    <td>
                                                        <?php 
                                                            switch(@$row-> estado_turma_curso ):
                                                                case "3": 
                                                                    echo "Inscrição";
                                                                    break;
                                                                case "2": 
                                                                    echo "Activa";
                                                                    break;
                                                                case "1": 
                                                                    echo "Encerrada";
                                                                    break;
                                                            endswitch;
                                                        ?>
                                                    </td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_turma_curso); ?></td>

                                                    <?php if (@$row-> estado_turma_curso == "3"):?>
                                                        <td>
                                                            <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewturmas');?>&id_a=<?php echo ProtegeTexto(base64_encode(@$row-> id_turma_curso)); ?>&btn=<?php echo CodificarTexto('active');?>" class="btn btn-success btn-raised btn-xs"><i class="zmdi zmdi-check"></i></a>
                                                        </td>

                                                        <td>
                                                            <a href="<?php echo '?pg='.CodificarTexto('formturma').'&id='.ProtegeTexto(base64_encode(@$row-> id_turma_curso)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
                                                        </td>

                                                        <td>
                                                            <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewturmas');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_turma_curso)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
                                                        </td>
                                                    <?php elseif (@$row-> estado_turma_curso == "2"):?>
                                                        <td></td>
                                                        <td>
                                                            <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewturmas');?>&id_e=<?php echo ProtegeTexto(base64_encode(@$row-> id_turma_curso)); ?>&btn=<?php echo CodificarTexto('close');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-close"></i></a>
                                                        </td>
                                                        <td></td>
                                                    <?php else:?>
                                                        <td></td>
                                                        <td>
                                                            <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewturmas');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-strop"></i></a>
                                                        </td>
                                                        <td></td>
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