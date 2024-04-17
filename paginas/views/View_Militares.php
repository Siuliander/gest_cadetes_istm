<?php require_once("./funcoes/Actions_Militar.php"); ?>

<?php

    $result = BuscarMilitar($id, NULL, NULL, $buscar , $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Militares</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('formmilitar');?>" >Adicionar</a></li>
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
                                                <th class="text-center">NOME DO MILITAR</th>
                                                <th class="text-center">B.I./PASSAPORTE</th>
                                                <th class="text-center">NIP</th>
                                                <th class="text-center">SANGUE</th>
                                                <th class="text-center">SEXO</th>
                                                <th class="text-center">DATA CORPORAÇÃO</th>
                                                <th class="text-center">PATENTE</th>
                                                <th class="text-center">QUADRO</th>
                                                <th class="text-center">RAMO</th>
                                                <th class="text-center">VISUALIZAR</th>
                                                <th class="text-center" colspan="1">Acção</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> nip); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> sangue); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> sexo); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_corporacao); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> patente); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> quadro); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> ramo); ?></td>
													
													
                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewMilitar');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_militar)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php echo '?pg='.CodificarTexto('formmilitar').'&id='.ProtegeTexto(base64_encode(@$row-> id_militar)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
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