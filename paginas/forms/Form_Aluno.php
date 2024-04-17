<?php require_once("./funcoes/Actions_Curso.php"); ?>
<?php require_once("./funcoes/Actions_Aluno.php"); ?>
<?php require_once("./funcoes/Actions_Sexo.php"); ?>
<?php require_once("./funcoes/Actions_Nacionalidade.php"); ?>
<?php require_once("./funcoes/Actions_Sangue.php"); ?>

<?php
    if( @$id != NULL):
        $result = BuscarAluno($id,null, $buscar, $admin, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;
    
    $Cursos = BuscarCurso(NULL,NULL, $admin, $conexao);
    $sexos = BuscarSexo(NULL , $conexao);
    $nacionalidades = BuscarNacionalidade(NULL , $conexao);
    $sangues = BuscarSangue(NULL , $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Formulário<small> Cadete</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('viewalunos');?>" >Ver Lista</a></li>
                <?php if (@$linha):  ?>
                    <li><a href="?pg=<?php echo CodificarTexto('formaluno');?>" >Adicionar Nova</a></li>
                <?php  endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
								
								<?php require_once("./includes/Popup_Resultado.php"); ?>
							
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewalunos').'&id='.CodificarTexto($linha->id_aluno); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formaluno" name="pg">
                                    </div>
                                
                                    <?php if (@$linha):  ?>
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_aluno); ?>" name="id">
                                            </div>
											
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label"></label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->identidade_pessoa); ?>" name="idd_p_up">
                                            </div>
											
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label"></label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_pessoa); ?>" name="id_p_up">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">B.I./Passaporte Em Edição</label>
                                                <input class="form-control" type="text" disabled value="<?php echo ($linha->identidade_pessoa); ?>">
                                            </div>
                           

                                            <div class="form-group label-floating">
                                                <label class="control-label">Aluno Em Edição</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>">
                                            </div>
                                    <?php  endif;?>
                                    
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Novo Nome Do Aluno' : 'Nome Do Novo Aluno'; ?></label>
                                        <input class="form-control" type="text" name="nome_pessoa" value="<?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>" required>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Novo B.I./Passaporte Do Aluno' : 'B.I./Passaporte Do Novo Aluno'; ?></label>
                                        <input class="form-control" type="identidade" name="identidade_pessoa" value="<?php echo (@$linha) ? $linha->identidade_pessoa : NULL; ?>" required>
                                    </div>
                                    
                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Nova Data De Nascimento' : 'Data De Nascimento'; ?></label>
                                        <input class="form-control" type="date" min = "<?= $Data_Min ;?>" max = "<?= $Data_Max ;?>" name="nascimento_pessoa" value="<?php echo (@$linha) ? $linha->nascimento_pessoa : NULL; ?>"  required>
                                    </div>
									
									<div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Sexo' : 'Sexo'; ?></label>
                                        <select class="form-control" type="select" name="sexo" required>
                                            <option></option>
                                            <?php if($sexos): while( $sexo = $sexos->fetchobject() ):?>
                                                <?php if( $sexo->id_sexo === $linha->id_sexo ):?>
                                                    <option selected value="<?php echo $sexo->id_sexo ;?>"> <?php echo $sexo->sexo ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $sexo->id_sexo ;?>"> <?php echo $sexo->sexo ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
                                        </select>
                                    </div>
									
									<div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Nacionalidade' : 'Nacionalidade'; ?></label>
                                        <select class="form-control" type="select" name="nacionalidade" required>
                                            <option></option>
                                            <?php if($nacionalidades): while( $nacionalidade = $nacionalidades->fetchobject() ):?>
                                                <?php if( $nacionalidade->id_nacionalidade === $linha->id_nacionalidade):?>
                                                    <option selected value="<?php echo $nacionalidade->id_nacionalidade ;?>"> <?php echo $nacionalidade->nacionalidade ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $nacionalidade->id_nacionalidade ;?>"> <?php echo $nacionalidade->nacionalidade ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
                                        </select>
                                    </div>
									
									<div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Tipo Sanguineo' : 'Tipo Sanguineo'; ?></label>
                                        <select class="form-control" type="select" name="sangue" required>
                                            <option></option>
                                            <?php if($sangues): while( $sangue = $sangues->fetchobject() ):?>
                                                <?php if( $sangue->id_sangue === $linha->id_sangue):?>
                                                    <option selected value="<?php echo $sangue->id_sangue ;?>"> <?php echo $sangue->sangue ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $sangue->id_sangue ;?>"> <?php echo $sangue->sangue ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
                                        </select>
                                    </div>

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

