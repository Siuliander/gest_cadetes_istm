<?php require_once("./funcoes/Actions_Matricula.php"); ?>

<?php

    $result = BuscarMatriculados($id , NULL, NULL, $buscar, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Matriculados</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="#" ></a></li>
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
                                                <th class="text-center">CURSO</th>
                                                <th class="text-center">ANO</th>
                                                <th class="text-center">TURMA</th>
                                                <th class="text-center">DATA MATRÍCULA</th>
                                                <th class="text-center">VISUALIZAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> sexo); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> curso); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> ano); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> turma); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_matricula); ?></td>
                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewMatricula');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_matricula)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
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