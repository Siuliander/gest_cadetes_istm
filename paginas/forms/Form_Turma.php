<?php require_once("./funcoes/Actions_Turma.php"); ?>
<?php require_once("./funcoes/Actions_Curso.php"); ?>
<?php require_once("./funcoes/Actions_Classe.php"); ?>

<?php
    if( @$id != NULL):
        $result = BuscarTurma($id,$buscar, 3, $admin, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
    
    $Cursos = BuscarCurso(NULL,NULL, $admin, $conexao);
    
    $Classes = BuscarClasse(NULL,NULL, 1, $conexao);

?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Formulário<small> Turma</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('viewturmas');?>" >Ver Lista</a></li>
                <?php if (@$linha):  ?>
                    <li><a href="?pg=<?php echo CodificarTexto('formturma');?>" >Adicionar Nova</a></li>
                <?php  endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
								
								<?php require_once("./includes/Popup_Resultado.php"); ?>
								
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewturmas').'&id='.CodificarTexto($linha->id_turma_curso); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formturma" name="pg">
                                    </div>
                                
                                    <?php if (@$linha):  ?>
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_turma_curso); ?>" name="id">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">Turma Em Edição</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->turma : NULL; ?>">
                                            </div>
                                    <?php  endif;?>

                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Curso' : 'Curso'; ?></label>
                                        <select class="form-control" type="select" name="curso" required>
                                            <option></option>
                                            <?php if($Cursos):while( $curso = $Cursos->fetchobject() ):?>
                                                <?php if( $curso->id_curso === $linha->id_curso ):?>
                                                    <option selected value="<?php echo $curso->id_curso ;?>"> <?php echo $curso->curso ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $curso->id_curso ;?>"> <?php echo $curso->curso ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile;endif; ?>
                                        </select>
                                    </div>
                                    

                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Ano Académico' : 'Ano Académico'; ?></label>
                                        <select class="form-control" type="select" name="classe" required>
                                            <option></option>
                                            <?php if($Classes):while( $classe = $Classes->fetchobject() ):?>
                                                <?php if( $classe->id_turma === $linha->id_turma ):?>
                                                    <option selected value="<?php echo $classe->id_turma ;?>"> <?php echo $classe->ano ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $classe->id_turma;?>"> <?php echo $classe->ano ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
                                        </select>
                                    </div>

                                    
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Nova Designação' : 'Turma'; ?></label>
                                        <input class="form-control" type="text" name="turma"  required value="<?php echo (@$linha) ? str_replace( '/'.$linha->ano_inicio_turma,'',$linha->turma) : NULL; ?>">
                                    </div>
                                    
                                    <div class="form-group label-floating">
                                        <label class="control-label">
											<?php // echo (@$linha) ? 'Novo Ano de Início' : 'Ano de Início'; ?>
											<?php echo 'Inicia Em < Ano De Início >'; ?>
										</label>
                                        <input class="form-control" type="number" min="<?= date('Y') ;?>" max="" name="anoInicio"  required value="<?php echo (@$linha) ? $linha->ano_inicio_turma : NULL; ?>">
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

