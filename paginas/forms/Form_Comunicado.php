<?php require_once("./funcoes/Actions_Comunicado.php"); ?>

<?php
    if( @$id != NULL):
        $result = BuscarComunicado($id,$buscar, $admin, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
    
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Formulário<small> Comunicado</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('viewcomunicados');?>" >Ver Lista</a></li>
                <?php if (@$linha):  ?>
                    <li><a href="?pg=<?php echo CodificarTexto('formcomunicado');?>" >Adicionar Nova</a></li>
                <?php  endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
								
								<?php require_once("./includes/Popup_Resultado.php"); ?>
							
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewcomunicados').'&id='.CodificarTexto($linha->id_comunicado); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formcomunicado" name="pg">
                                    </div>
                                
                                    <?php if (@$linha):  ?>
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_comunicado); ?>" name="id">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">Comunicado Em Edição</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->titulo_comunicado : NULL; ?>">
                                            </div>
                                    <?php  endif;?>


                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Novo Titulo' : 'Titulo'; ?></label>
                                        <input class="form-control" type="text" name="titulo"  required value="<?php echo (@$linha) ? $linha->titulo_comunicado : NULL; ?>">
                                    </div>

                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Nova Descrição' : 'Descrição'; ?></label>
                                        <textarea class="form-control" type="text" name="descricao"  required ><?php echo (@$linha) ? $linha->descricao_comunicado : NULL; ?></textarea>
                                    </div>
                                    
                                    <p class="text-center">
                                        <button class="btn btn-reset btn-raised btn-sm" type="reset" name="btn"><i class="zmdi zmdi-reset"></i> Limpar</button>

                                        <?php if (@$linha):  ?>
                                            <button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('update');?>"><i class="zmdi zmdi-floppy"></i> Salvar Edição</button>
                                        <?php else:  ?>
                                            <button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('add');?>"><i class="zmdi zmdi-floppy"></i> Salvar</button>
                                        <?php  endif;?>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>

