<?php require_once("./funcoes/Actions_Disciplina_Turma.php"); ?>

<?php
    $result = BuscarDisciplinaTurma($id,$buscar, null,null,null, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Disciplinas / Turma</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('formdisciplinaturma');?>" >Adicionar</a></li>
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
                                                <th class="text-center">Ano</th>
                                                <th class="text-center">Disciplina</th>
                                                <th class="text-center" colspan="2">Acção</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> curso); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> ano); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> disciplina); ?></td>
                                                    <td>
                                                        <a href="<?php echo '?pg='.CodificarTexto('formdisciplinaturma').'&id='.ProtegeTexto(base64_encode(@$row-> id_disciplina)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-confirm btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewdisciplinasturmas');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_disciplina)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
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