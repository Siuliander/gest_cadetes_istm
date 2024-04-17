<?php require_once("./funcoes/Actions_Patente.php"); ?>
<?php require_once("./funcoes/Actions_Quadro.php"); ?>
<?php require_once("./funcoes/Actions_Ramo.php"); ?>
<?php require_once("./funcoes/Actions_Militar.php"); ?>


<?php
    if( @$id != NULL):
        $result = BuscarMilitar($id,NULL,NULL, $buscar, $conexao);

        if (@$result and (@$result->rowCount() > 0)):  
            $linha = $result->fetchobject();
        endif;
    endif;

	
    $patentes = BuscarPatente(NULL , $conexao);
    $quadros = BuscarQuadro(NULL , $conexao);
    $ramos = BuscarRamo(NULL , $conexao);
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Formulário<small> Militar</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li><a href="?pg=<?php echo CodificarTexto('viewmilitares');?>" >Ver Lista</a></li>
                <?php if (@$linha):  ?>
                    <li><a href="?pg=<?php echo CodificarTexto('formmilitar');?>" >Adicionar Nova</a></li>
                <?php  endif;?>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
							
								<?php require_once("./includes/Popup_Resultado.php"); ?>
								
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('viewmilitares').'&id='.CodificarTexto($linha->id_militar); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formmilitar" name="pg">
                                    </div>
                                
                                    <?php if (@$linha):  ?>
                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_militar); ?>" name="id">
                                            </div>
                                            
                                            <div hidden class="form-group label-floating">
                                                <input class="form-control" type="text" hidden value="<?php echo base64_encode($linha->identidade_pessoa); ?>" name="idd_p_up">
                                            </div>

                                            <div hidden class="form-group label-floating">
                                                <label hidden class="control-label">ID PESSOA</label>
                                                <input hidden class="form-control" type="text" value="<?php echo base64_encode($linha->id_pessoa); ?>" name="id_p_up">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">B.I./Passaporte Em Edição</label>
                                                <input class="form-control" type="text" disabled value="<?php echo ($linha->identidade_pessoa); ?>">
                                            </div>

                                            <div class="form-group label-floating">
                                                <label class="control-label">Militar Em Edição</label>
                                                <input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->nome_pessoa : NULL; ?>">
                                            </div>
                                    <?php  endif;?>


                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'Novo B.I./Passaporte Pessoal' : 'B.I./Passaporte Pessoal'; ?></label>
                                        <input class="form-control" type="text" name="identidade" value="<?php echo (@$linha) ? $linha->identidade_pessoa : NULL; ?>" required>
                                    </div>
									
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo (@$linha) ? 'NIP ' : 'NIP'; ?></label>
                                        <input class="form-control" type="text" name="nip" value="<?php echo (@$linha) ? $linha->nip : NULL; ?>" required>
                                    </div>
									
                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Data Da Corporação' : 'Data Da Corporação'; ?></label>
                                        <input class="form-control" type="date" max = "<?php echo date('Y-m-d') ;?>" name="datacorporacao" value="<?php echo (@$linha) ? $linha->data_corporacao : NULL; ?>"  required>
                                    </div>
                                    
                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Nova Patente' : 'Patente'; ?></label>
                                        <select class="form-control" type="select" name="patente" required>
                                            <option></option>
                                            <?php if($patentes): while( $patente = $patentes->fetchobject() ):?>
                                                <?php if( $patente->id_patente === $linha->id_patente ):?>
                                                    <option selected value="<?php echo $patente->id_patente ;?>"> <?php echo $patente->patente ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $patente->id_patente ;?>"> <?php echo $patente->patente ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Novo Quadro' : 'Quadro'; ?></label>
                                        <select class="form-control" type="select" name="quadro" required>
                                            <option></option>
                                            <?php if($quadros): while( $quadro = $quadros->fetchobject() ):?>
                                                <?php if( $quadro->id_quadro === $linha->id_quadro ):?>
                                                    <option selected value="<?php echo $quadro->id_quadro ;?>"> <?php echo $quadro->quadro ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $quadro->id_quadro ;?>"> <?php echo $quadro->quadro ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group label-floating">
                                        <label class="control-"><?php echo (@$linha) ? 'Novo Ramo' : 'Ramo'; ?></label>
                                        <select class="form-control" type="select" name="ramo" required>
                                            <option></option>
                                            <?php if($ramos): while( $ramo = $ramos->fetchobject() ):?>
                                                <?php if( $ramo->id_ramo === $linha->id_ramo ):?>
                                                    <option selected value="<?php echo $ramo->id_ramo ;?>"> <?php echo $ramo->ramo ;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $ramo->id_ramo ;?>"> <?php echo $ramo->ramo ;?></option>
                                                <?php endif; ?>
                                            <?php endwhile; endif; ?>
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

