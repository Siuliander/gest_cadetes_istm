<?php // require_once("./funcoes/Actions_Pessoa.php"); ?>

<?php 

	$btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    $id_e = (DecodificarTexto( isset($_POST["id_e"]) ? @$_POST["id_e"] : (isset($_GET["id_e"]) ? $_GET["id_e"] : NULL) ));
    
    $nip =  ( isset($_POST["nip"]) ? $_POST["nip"] : (isset($_GET["nip"]) ? $_GET["nip"] : NULL) );
    $patente =  ( isset($_POST["patente"]) ? $_POST["patente"] : (isset($_GET["patente"]) ? $_GET["patente"] : NULL) );
    $quadro =  ( isset($_POST["quadro"]) ? $_POST["quadro"] : (isset($_GET["quadro"]) ? $_GET["quadro"] : NULL) );
    $ramo =  ( isset($_POST["ramo"]) ? $_POST["ramo"] : (isset($_GET["ramo"]) ? $_GET["ramo"] : NULL) );
    $data_corporacao =  ( isset($_POST["datacorporacao"]) ? $_POST["datacorporacao"] : (isset($_GET["datacorporacao"]) ? $_GET["datacorporacao"] : NULL) );
    $identidade_pessoa =  ( isset($_POST["identidade"]) ? $_POST["identidade"] : (isset($_GET["identidade"]) ? $_GET["identidade"] : NULL) );
    
    $admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;
	
	// var_dump($_REQUEST);


    function BuscarMilitar($Id = NULL , $Identidade = NULL, $Nip = NULL, $Buscar = NULL , $Conexao)
    {
        if(@$Conexao)
        {
            $query = "SELECT * FROM tb_militar AS militar
						JOIN tb_patente AS patente 
							ON patente.id_patente = militar.id_patente
						JOIN tb_quadro AS quadro 
							ON quadro.id_quadro = militar.id_quadro
						JOIN tb_ramo AS ramo 
							ON ramo.id_ramo = militar.id_ramo			
						JOIN tb_pessoa AS pessoa 
							ON pessoa.id_pessoa = militar.id_pessoa
						JOIN tb_sexo AS sexo 
							ON sexo.id_sexo = pessoa.id_sexo
						JOIN tb_nacionalidade AS nacionalidade 
							ON nacionalidade.id_nacionalidade = pessoa.id_nacionalidade
						JOIN tb_sangue AS sangue 
							ON sangue.id_sangue = pessoa.id_sangue
			
					  WHERE (estado_militar = 1) ";

            if(@$Id != NULL ): 
                $query = $query . " AND id_militar = :id ";
            elseif(@$Identidade != NULL ): 
                $query = $query . " AND identidade_pessoa = :identidade ";
            elseif(@$Nip != NULL ): 
                $query = $query . " AND (nip = :nip )";
            elseif(@$Id == NULL & @$Identidade == NULL & @$Nip == NULL & @$Buscar != NULL): 
                $query = $query . " AND identidade_pessoa = :identidade ";
                $query = $query . " AND nip = :nip ";
                $query = $query . " AND nome_pessoa = :nome ";
                $query = $query . " AND patente = :patente ";
                $query = $query . " AND quadro = :quadro ";
                $query = $query . " AND ramo = :ramo ";
                $query = $query . " AND sangue = :sangue ";
            endif;
            
            $result = @$Conexao->prepare(@$query);
            
            if(@$Id != NULL): 
                @$result -> bindParam(":id", $Id, PDO::PARAM_INT);
            elseif(@$Identidade != NULL ): 
                @$result -> bindParam(":identidade", $Identidade, PDO::PARAM_STR);
            elseif(@$Nip != NULL ): 
                @$result -> bindParam(":nip", $Nip, PDO::PARAM_STR);
            elseif(@$Id == NULL & @$Identidade == NULL & @$Nip == NULL & $Buscar != NULL):
				$Buscar = "%".$Buscar."%"; 
                @$result -> bindParam(":identidade", $Buscar, PDO::PARAM_STR);
                @$result -> bindParam(":nip", $Buscar, PDO::PARAM_STR);
                @$result -> bindParam(":nome", $Buscar, PDO::PARAM_STR);
                @$result -> bindParam(":patente", $Buscar, PDO::PARAM_STR);
                @$result -> bindParam(":quadro", $Buscar, PDO::PARAM_STR);
                @$result -> bindParam(":ramo", $Buscar, PDO::PARAM_STR);
                @$result -> bindParam(":sangue", $Buscar, PDO::PARAM_STR);
            endif;
			

            @$result->execute(); 
			

            if(@$result->rowCount() > 0 )
            {
                return @$result;
            }
        }

        return FALSE;
    }
	
	function VerificarPessoa($Valor = NULL , $conexao)
    {
        
        
            if(@$conexao){

                $query = "SELECT * FROM tb_pessoa WHERE identidade_pessoa = :valor LIMIT 1 ";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":valor", $Valor, PDO::PARAM_STR);
               
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        return FALSE;
    }

    function AddMilitar($Nip = NULL , $Identidade = NULL , $DataCorporacao = NULL, $Patente = NULL , $Quadro = NULL , $Ramo = NULL , $Conexao)
    {
				
        if($Nip != NULL & $Identidade != NULL & $DataCorporacao != NULL & $Patente != NULL & $Quadro != NULL & $Ramo != NULL):
            
            if(@$Conexao)
            {
                $verificarIdentidade = BuscarMilitar( NULL , $Identidade , NULL, NULL, $Conexao );
				$verificarNIP = BuscarMilitar( NULL , NULL , $Nip, NULL, $Conexao );
				
                if(@$verificarIdentidade || @$verificarNIP):
                    return FALSE;
					var_dump( 'Verificar ID Pessoa:' . $verificarIdentidade );
					var_dump( 'Verificar NIP:' . $verificarNIP );
                else:
                    $verificar = VerificarPessoa( $Identidade , $Conexao );
					
					if($verificar):
						$Pessoa = $verificar->fetchobject()->id_pessoa;
						
						$query = "INSERT INTO tb_militar 
						(id_pessoa ,nip,data_corporacao,data_militar,id_patente,id_quadro,id_ramo) VALUES 
						(:pessoa,:nip,:corporacao,NOW(),:patente,:quadro,:ramo)";
						

						$result = @$Conexao->prepare(@$query);

						$result -> bindParam(":pessoa", $Pessoa, PDO::PARAM_INT);
						$result -> bindParam(":nip", $Nip, PDO::PARAM_STR);
						$result -> bindParam(":corporacao", $DataCorporacao, PDO::PARAM_STR);
						$result -> bindParam(":patente", $Patente, PDO::PARAM_INT);
						$result -> bindParam(":quadro", $Quadro, PDO::PARAM_INT);
						$result -> bindParam(":ramo", $Ramo, PDO::PARAM_INT);
						
						$result->execute();

						if($result->rowCount() > 0 )
						{
							return $Conexao->lastInsertId();
						}
						
					endif;

                endif;
            }
        endif;

        return FALSE;
    }
	
	function VerificarMilitar($Id = NULL, $Valor = NULL, $conexao)
    {
		if(@$conexao){

			$query = "SELECT id_militar, pessoa.id_pessoa FROM tb_militar AS militar JOIN tb_pessoa AS pessoa ON pessoa.id_pessoa = militar.id_pessoa WHERE id_militar != :id AND identidade_pessoa = :valor LIMIT 1 ";
			
			$result = @$conexao->prepare(@$query);
			
			$result -> bindParam(":id", $Id, PDO::PARAM_STR);
			$result -> bindParam(":valor", $Valor, PDO::PARAM_STR);
		   
			$result->execute(); 

			if($result->rowCount() > 0 )
			{
				return $result;
			}
		}

        return FALSE;
    }

    function UpdateMilitar($Id = NULL, $Nip = NULL , $Identidade = NULL , $DataCorporacao = NULL, $Patente = NULL , $Quadro = NULL , $Ramo = NULL,$Conexao)
    {

        if($Id != NULL & $Nip != NULL & $Identidade != NULL & $DataCorporacao != NULL & $Patente != NULL & $Quadro != NULL & $Ramo != NULL):

            if(@$Conexao){
                
				$verificar = VerificarMilitar( $Id, $Identidade , $Conexao );
					
				if(!$verificar):
					
					$verificarP = VerificarPessoa( $Identidade , $Conexao );
				
					if($verificarP):
						$Pessoa = $verificarP->fetchobject()->id_pessoa;
						
						$query = "UPDATE tb_militar 
						  SET 
							id_pessoa = :pessoa,
							nip = :nip ,  
							data_corporacao = :corporacao,
							id_patente = :patente,
							id_quadro= :quadro,
							id_ramo = :ramo
						  WHERE  
							id_militar = :id 
						  LIMIT 1";
                
						$result = @$Conexao->prepare($query);
						$result -> bindParam(":id", $Id, PDO::PARAM_INT);
						$result -> bindParam(":pessoa", $Pessoa, PDO::PARAM_INT);
						$result -> bindParam(":nip", $Nip, PDO::PARAM_STR);
						$result -> bindParam(":corporacao", $DataCorporacao, PDO::PARAM_STR);
						$result -> bindParam(":patente", $Patente, PDO::PARAM_INT);
						$result -> bindParam(":quadro", $Quadro, PDO::PARAM_INT);
						$result -> bindParam(":ramo", $Ramo, PDO::PARAM_INT);
							
						$result->execute();

						if($result->rowCount() > 0 )
						{
							return TRUE;
						}
						
					endif;
					
				endif;
                
            }

        endif;

        return FALSE;
    }

if ( in_array(DecodificarTexto($pagina) ,["formmilitar","viewmilitares"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddMilitar($nip , $identidade_pessoa , $data_corporacao , $patente , $quadro , $ramo , $conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateMilitar($id, $nip , $identidade_pessoa , $data_corporacao , $patente , $quadro , $ramo ,$conexao);
                break;
            
            case 'buscar':
                //echo "Caso: Recover";
                BuscarMilitar($id,$identidade_pessoa, $nip, $buscar, $conexao);
                break;
              
            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
