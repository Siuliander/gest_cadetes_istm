<?php
	$result = NULL;
    $linha = NULL;
	$Updated = FALSE ;

	$btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;
    
	$id = ( isset($_POST["id"]) ? $_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : 0) ) ;
    $nivel = ( isset($_POST["nivel"]) ? $_POST["nivel"] : (isset($_GET["nivel"]) ? $_GET["nivel"] : 0) ) ;
	$identidade = ( isset($_POST["identidade"]) ? $_POST["identidade"] : (isset($_GET["identidade"]) ? $_GET["identidade"] : NULL) ) ;
	
	$permissao = 0 ;
	$myId = 0 ;
	
	if( isset($permissao_cookie) & in_array(@$permissao_cookie,[1]) & isset( $_SESSION['id'] )):
		$permissao = @$permissao_cookie ;
		$myId = $_SESSION['id'] ;
	endif;
	
   function BuscarUsuario( $Id = NULL , $MyId = 0 , $Identidade = NULL , $Nivel = 0 , $Permissao = 0 , $Conexao )
	{
		if(  @$Identidade != NULL & in_array( @$Nivel , [1,2,3] ) ):
			
			if( in_array( @$MyId > 0 & @$Permissao , [ 1 ]) ):
	
				if( @$Conexao ):
					
					$query = "";
					
					if( @$Nivel == 1 ):
						$query = "SELECT 
									admin.id_admin AS id, 
									identidade_pessoa AS identidade , 
									nome_pessoa AS nome
								  FROM tb_admin AS admin
									JOIN tb_pessoa AS pessoa
									ON pessoa.id_pessoa = admin.id_pessoa
								  WHERE 
									estado_admin = 1 AND 
									identidade_pessoa = :identidade AND 
									id_admin != :id 
								  LIMIT 1";
					elseif( @$Nivel == 2 ):
						$query = "SELECT 
									docente.id_docente AS id, 
									identidade_pessoa AS identidade , 
									nome_pessoa AS nome
								  FROM tb_docente AS docente
								  JOIN tb_pessoa AS pessoa
									ON pessoa.id_pessoa = docente.id_pessoa
								  WHERE 
									estado_docente = 1 AND 
									identidade_pessoa = :identidade
								  LIMIT 1";
					elseif( @$Nivel == 3 ):
						$query = "SELECT 
									aluno.id_aluno AS id, 
									identidade_pessoa AS identidade , 
									nome_pessoa AS nome
								  FROM tb_aluno AS aluno
								  JOIN tb_pessoa AS pessoa
									ON pessoa.id_pessoa = aluno.id_pessoa
								  WHERE 
									estado_aluno = 1 AND 
									identidade_pessoa = :identidade
								  LIMIT 1";
					endif;
					
					$result = @$Conexao->prepare(@$query);
					
					if( @$Nivel == 1 ):
						$result -> bindParam(":id", $MyId, PDO::PARAM_INT);
					endif;
					
					$result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
					
					$result->execute();
					
					if (@$result and (@$result->rowCount() > 0)):  
						Return @$result ;
					endif;
				endif;
			endif;
		endif;
		
		return FALSE ;
	}
	
	function VerificarUsuario( $Id = NULL , $MyId = 0 , $Identidade = NULL , $Nivel = 0 , $Permissao = 0 , $Conexao )
	{
		if(  @$Identidade != NULL & in_array( @$Nivel , [1,2,3] ) ):
			
			if( in_array( @$MyId > 0 & @$Permissao , [ 1 ]) ):
	
				if( @$Conexao ):
					
					$query = "";
					
					if( @$Nivel == 1 ):
						$query = "SELECT 
									admin.id_admin AS id, 
									identidade_pessoa AS identidade , 
									nome_pessoa AS nome
								  FROM tb_admin AS admin
									JOIN tb_pessoa AS pessoa
									ON pessoa.id_pessoa = admin.id_pessoa
								  WHERE 
									estado_admin = 1 AND 
									id_admin = :id AND 
									identidade_pessoa = :identidade AND 
									id_admin != :myid
								  LIMIT 1";
					elseif( @$Nivel == 2 ):
						$query = "SELECT 
									docente.id_docente AS id, 
									identidade_pessoa AS identidade , 
									nome_pessoa AS nome
								  FROM tb_docente AS docente
								  JOIN tb_pessoa AS pessoa
									ON pessoa.id_pessoa = docente.id_pessoa
								  WHERE 
									estado_docente = 1 AND 
									id_docente = :id AND 
									identidade_pessoa = :identidade
								  LIMIT 1";
					elseif( @$Nivel == 3 ):
						$query = "SELECT 
									aluno.id_aluno AS id, 
									identidade_pessoa AS identidade , 
									nome_pessoa AS nome
								  FROM tb_aluno AS aluno
								  JOIN tb_pessoa AS pessoa
									ON pessoa.id_pessoa = aluno.id_pessoa
								  WHERE 
									estado_aluno = 1 AND 
									id_aluno = :id AND 
									identidade_pessoa = :identidade
								  LIMIT 1";
					endif;
					
					$result = @$Conexao->prepare(@$query);
					
					if( @$Nivel == 1 ):
						$result -> bindParam(":myid", $MyId, PDO::PARAM_INT);
					endif;
					
					
					$result -> bindParam(":id", $Id, PDO::PARAM_INT);
					$result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
					
					$result->execute();
					
					
					if (@$result and (@$result->rowCount() > 0)):  
						Return @$result ;
					endif;
				endif;
			endif;
		endif;
		
		return FALSE ;
	}
	
	function ResetSenha( $Id = NULL , $MyId = 0 , $Identidade = NULL , $Nivel = 0 , $Permissao = 0 , $Conexao )
	{
		if( @$Id != 0 & @$Identidade != NULL & @$MyId != 0 & @$Nivel != 0 ):
	
			if( @$Conexao ):
				
				$dados = VerificarUsuario($Id , $MyId , $Identidade , $Nivel , $Permissao , $Conexao);
				
				if (@$dados and (@$dados->rowCount() > 0)):  
					$dado = $dados->fetchobject() ;
					
					$query = "";
					
					if( @$Nivel == 1 ):
						$query = "UPDATE tb_admin SET senha_admin = md5( 1234 ) WHERE estado_admin = 1 AND id_admin = :id LIMIT 1";
					elseif( @$Nivel == 2 ):
						$query = "UPDATE tb_docente SET senha_docente = md5( 1234 ) WHERE estado_docente = 1 AND id_docente = :id LIMIT 1";
					elseif( @$Nivel == 3 ):
						$query = "UPDATE tb_aluno SET senha_aluno = md5( :senha ) WHERE estado_aluno = 1 AND id_aluno = :id AND LIMIT 1";
					endif;
					
					$result = @$Conexao->prepare(@$query);
					
					$result -> bindParam(":id", $dado->id , PDO::PARAM_INT);
					
					$result->execute();
					
					if (@$result):  
						Return TRUE ;
					endif;
					
				endif;
			endif;
		endif;
		
		return FALSE ;
	}
	if ( in_array(DecodificarTexto($pagina) ,["formresetsenha"]) ):
        switch( $btn ):
            case 'buscar':
                //echo "Caso: Buscar";
                $result = BuscarUsuario($id, $myId , $identidade , $nivel , $permissao , $conexao);
				if( @$result ):
					$linha = @$result->fetchobject();
				endif;
                break;
            case 'reset':
                //echo "Caso: Reset";
                $Updated = ResetSenha($id, $myId , $identidade , $nivel , $permissao , $conexao);
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
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i>Resetar<small> Senha</small></h1>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
				<?php if ( @$linha ):?>
					<?php if ( in_array( $permissao , [1] ) ):?>
						<li><a href="?pg=<?php echo CodificarTexto('formresetsenha');?>" >Nova Consulta</a></li>
					<?php else:?>
						<li><a href="#" ></a></li>
					<?php endif;?>
				<?php else:?>
					<li><a href="#" ></a></li>
				<?php endif;?>
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
								
                                <form action="<?php /* if (@$linha): */ echo '?pg='.CodificarTexto('formresetsenha'); /* else: $_SERVER ['PHP_SELF'] ; endif; */ ?>" method="post" enctype="multipart/form-data">

                                    <div hidden class="form-group label-floating">
                                        <input hidden class="form-control" type="text" value="formresetsenhasenha" name="pg">
                                    </div>
									<?php if (!@$linha ):  ?>
									<div class="form-group label-floating">
										<label class="control-label" for="UserId">Reset De</label>
										<select class="form-control" id="UserEmail" type="text" name="nivel">
											<option value="1" selected>Administração</option>
											<option value="2">Docente</option>
											<option value="3">Cadete</option>
										</select>
									</div>
									
									<div class="form-group label-floating">
										<label class="control-label">B.I./Passaporte</label>
										<input class="form-control" type="text" name="identidade">
									</div>
									
									<?php elseif (@$linha):  ?>
									
											<input class="form-control" hidden type="hidden" name="nivel" value="<?php echo @$nivel; ?>">
										
											<input class="form-control" hidden type="hidden" name="id" value="<?php echo (@$linha) ? $linha->id : NULL; ?>">
										
											<input class="form-control" hidden type="hidden" name="identidade" value="<?php echo (@$linha) ? $linha->identidade : NULL; ?>">
										
										
										
										<div class="form-group label-floating">
											<label class="control-label">Usuário</label>
											<input class="form-control" type="text" disabled  required value="<?php echo (@$linha) ? $linha->nome : NULL; ?>">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">B.I./Passaporte</label>
											<input class="form-control" disabled type="text" value="<?php echo (@$linha) ? $linha->identidade : NULL; ?>">
										</div>
									<?php  endif;?>
									
									
									<?php if (!@$linha ):  ?>
										<p class="text-center">
											<button class="btn btn-reset btn-raised btn-sm" type="reset" name="btn"><i class="zmdi zmdi-reset"></i> Limpar</button>
											<button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('buscar');?>"><i class="zmdi zmdi-floppy"></i> Buscar</button>
										</p>
									<?php elseif (@$linha):  ?>
										
										<p class="text-center">
											<button class="btn btn-info btn-raised btn-sm" type="submit" name="btn" value="<?php echo CodificarTexto('reset');?>"><i class="zmdi zmdi-floppy"></i> Resetar Senha</button>
										</p>
									<?php  endif;?>
									
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				
				
                
            </div>
        </div>
    </div>
</div>

