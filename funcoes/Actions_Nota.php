<?php 
	
	$id = (( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
	$matricula = ( isset($_POST["matricula"]) ? $_POST["matricula"] : (isset($_GET["matricula"]) ? $_GET["matricula"] : NULL) );
    $nota1 = (( isset($_POST["nota1"]) ? @$_POST["nota1"] : (isset($_GET["nota1"]) ? $_GET["nota1"] : 0) ));
    $nota2 = (( isset($_POST["nota2"]) ? @$_POST["nota2"] : (isset($_GET["nota2"]) ? $_GET["nota2"] : 0) ));
    $exame = (( isset($_POST["exame"]) ? @$_POST["exame"] : (isset($_GET["exame"]) ? $_GET["exame"] : 0) ));
    $recurso = (( isset($_POST["recurso"]) ? @$_POST["recurso"] : (isset($_GET["recurso"]) ? $_GET["recurso"] : 0) ));
     
    $result = NULL;
    $linha = NULL;

	
    function UpdateNota($Id = 0 , $Matricula = 0 , $Nota1 = 0 , $Nota2 = 0 , $Exame = 0 , $Recurso = 0 , $conexao)
    {
		if(@$Id != NULL & @$Matricula != NULL):
			if(@$conexao)
			{
				$query = "UPDATE tb_nota 
							SET 
								nota1 = :nota1, 
								nota2 = :nota2, 
								exame = :exame, 
								recurso = :recurso 
							WHERE 
								estado_nota = 2 AND 
								id_nota = :id AND 
								id_matricula = :matricula
								LIMIT 1";
				
				$result = @$conexao->prepare(@$query);
			
				$result -> bindParam(":id", $Id, PDO::PARAM_INT);
				$result -> bindParam(":matricula", $Matricula, PDO::PARAM_INT);
				$result -> bindParam(":nota1", $Nota1, PDO::PARAM_INT);
				$result -> bindParam(":nota2", $Nota2, PDO::PARAM_INT);
				$result -> bindParam(":exame", $Exame, PDO::PARAM_INT);
				$result -> bindParam(":recurso", $Recurso, PDO::PARAM_INT);
			
				$result->execute(); 

				if($result->rowCount() > 0 )
				{
					return $result;
				}
            }
		endif;
            
        return FALSE;
    }
	
	if ( in_array(DecodificarTexto($pagina) ,["formnota","viewnotas"]) ):
        switch( $btn ):
            
            case 'update':
                //echo "Caso: Update";
                UpdateNota($id, $matricula, $nota1, $nota2, $exame, $recurso, $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
	
?>
