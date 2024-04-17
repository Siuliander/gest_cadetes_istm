<?php require_once("./funcoes/Actions_Curso.php"); ?>

<?php
    if( @$id != NULL):
        $result = BuscarCurso($id,$buscar, $admin, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
    
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Formulário<small> Curso</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('viewcursos');?>" >Ver Lista</a></li>
                <?php if (@$linha):  ?>
                    <li><a href="?pg=<?php echo CodificarTexto('formcurso');?>" >Adicionar Novo</a></li>
                <?php  endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
								
								<?php require_once("./includes/Popup_Resultado.php"); ?>
							
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewcursos').'&id='.CodificarTexto($linha->id_curso); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formcurso" name="pg">
                                    </div>
                                
                                    <?php if (@$linha):  ?>
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID CURSO</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_curso); ?>" name="id">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">Curso Em Edição</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->curso : NULL; ?>">
                                            </div>
                                    <?php  endif;?>


                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Nova Designação' : 'Curso'; ?></label>
                                        <input class="form-control" type="text" name="curso"  required value="">
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

