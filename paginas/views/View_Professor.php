<?php require_once("./funcoes/Actions_Professor.php"); ?>

<?php

    $result = BuscarDocente($id , NULL , $buscar, $admin, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Docentes</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('formdocente');?>" >Adicionar</a></li>
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
                                                <th class="text-center">NOME DO Docente</th>
                                                <th class="text-center">B.I./PASSAPORTE</th>
                                                <th class="text-center">DATA ADESÃO</th>
                                                <th class="text-center">DISCIPLINA</th>
                                                <th class="text-center">DISCIPLINA 2</th>
                                                <th class="text-center">DISCIPLINA 3</th>
                                                <th class="text-center">VISUALIZAR</th>
                                                <th class="text-center" colspan="2">Acção</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_docente); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> disciplina); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> disciplina2); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> disciplina3); ?></td>
													
                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewDocente');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_docente)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php echo '?pg='.CodificarTexto('formdocente').'&id='.ProtegeTexto(base64_encode(@$row-> id_docente)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewdocentes');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_docente)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
                                                    </td>

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