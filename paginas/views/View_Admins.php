<?php require_once("./funcoes/Actions_Admin.php"); ?>

<?php

    $result = BuscarAdmin($id , NULL , $buscar, $admin, $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Lista de<small> Administradores</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('formadmin');?>" >Adicionar</a></li>
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
                                                <th class="text-center">NOME DO ADMINISTRADOR</th>
                                                <th class="text-center">B.I./PASSAPORTE</th>
                                                <th class="text-center">NÍVEL</th>
                                                <th class="text-center">DATA ADESÃO</th>
                                                <th class="text-center">ACTUALIZAÇÃO</th>
                                                <th class="text-center">VISUALIZAR</th>
                                                <th class="text-center" colspan="2">Acção</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php while ($row = @$result->fetchobject() ) { ?>
                                                <tr>
                                                    <td><?php echo ProtegeTexto(@$row-> nome_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> identidade_pessoa); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> nivel); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_admin); ?></td>
                                                    <td><?php echo ProtegeTexto(@$row-> data_actualizacao_admin); ?></td>
													
                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewAdmin');?>&id=<?php echo ProtegeTexto(base64_encode(@$row-> id_admin)); ?>" class="btn btn-blue btn-raised btn-xs"><i class="zmdi zmdi-eye"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php echo '?pg='.CodificarTexto('formadmin').'&id='.ProtegeTexto(base64_encode(@$row-> id_admin)); ?>&btn=<?php echo CodificarTexto('editar');?>" class="btn btn-info btn-raised btn-xs"><i class="zmdi zmdi-edit"></i></a>
                                                    </td>

                                                    <td>
                                                        <a href="<?php $_SERVER ['PHP_SELF'] ;?>?pg=<?php echo CodificarTexto('viewadmins');?>&id_d=<?php echo ProtegeTexto(base64_encode(@$row-> id_admin)); ?>&btn=<?php echo CodificarTexto('delete');?>" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a>
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