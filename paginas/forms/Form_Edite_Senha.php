<?php
	$result = NULL;
    $linha = NULL;

	$btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;
    $id = isset( $_SESSION['id'] ) ? @$_SESSION['id'] : 0;
    $nivel = isset( $_SESSION['nivel'] ) ? @$_SESSION['nivel'] : 0;
	$senha =  ( isset($_POST["senha"]) ? $_POST["senha"] : (isset($_GET["senha"]) ? $_GET["senha"] : NULL) ) ;
    $senhaAntiga =  ( isset($_POST["senhaAntiga"]) ? $_POST["senhaAntiga"] : (isset($_GET["senhaAntiga"]) ? $_GET["senhaAntiga"] : NULL) ) ;
	
	$Updated = FALSE ;
   
	
	function UpdateSenha( $Id = 0 , $Senha = NULL , $SenhaAntiga = NULL , $Nivel = 0 , $Conexao )
	{
		if( @$Id != 0 & @$Senha != NULL & @$Senha != NULL & @$Nivel != 0 ):
	
			if( @$Conexao ):
				
				$query = "";
				
				if( @$Nivel == 1 ):
					$query = "UPDATE tb_admin SET senha_admin = md5( :senha ) WHERE estado_admin = 1 AND id_admin = :id AND senha_admin = md5( :senhaAntiga ) LIMIT 1";
				elseif( @$Nivel == 2 ):
					$query = "UPDATE tb_docente SET senha_docente = md5( :senha ) WHERE estado_docente = 1 AND id_docente = :id AND senha_docente = md5( :senhaAntiga ) LIMIT 1";
				elseif( @$Nivel == 3 ):
					$query = "UPDATE tb_aluno SET senha_aluno = md5( :senha ) WHERE estado_aluno = 1 AND id_aluno = :id AND senha_aluno = md5( :senhaAntiga ) LIMIT 1";
				endif;
				
				$result = @$Conexao->prepare(@$query);
				
				$result -> bindParam(":id", $Id, PDO::PARAM_INT);
				$result -> bindParam(":senha", $Senha, PDO::PARAM_STR);
				$result -> bindParam(":senhaAntiga", $SenhaAntiga, PDO::PARAM_STR);
				
				$result->execute();
				
				if (@$result and (@$result->rowCount() > 0)):  
					Return TRUE ;
				endif;
			endif;
		endif;
		
		return FALSE ;
	}
	if ( in_array(DecodificarTexto($pagina) ,["formsenha"]) ):
        switch( $btn ):
            case 'update':
                //echo "Caso: Update";
                $Updated =UpdateSenha($id , $senha , $senhaAntiga , $nivel , $conexao);
                break;
				
            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>

<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Alterar<small> Senha</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
					<li><a href="#" ></a></li>
            </ul>
           
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="new">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-10 col-md-offset-1">
							
								<?php if ( $Updated == 1 ):  ?>
									 <center>
										<div center class="alert alert-success alert-dismissible" role="alert">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											Sucesso
										</div>
									</center>
								<?php  endif;?>
								
                                <form action="<?php if (@$linha): echo '?pg='.CodificarTexto('formsenha'); else: $_SERVER ['PHP_SELF'] ; endif;?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formsenha" name="pg">
                                    </div>
									
									<div class="form-group label-floating">
										<label class="control-label">Senha Antiga</label>
										<input class="form-control" type="password" name="senhaAntiga">
									</div>
									
									<div class="form-group label-floating">
										<label class="control-label">Nova Senha</label>
										<input class="form-control" type="password" name="senha">
									</div>
									
                                    <p class="text-center">
										<button class="btn btn-reset btn-raised btn-sm" type="reset" name="btn"><i class="zmdi zmdi-reset"></i> Limpar</button>
										<button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('update');?>"><i class="zmdi zmdi-floppy"></i> Alterar Senha</button>
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

