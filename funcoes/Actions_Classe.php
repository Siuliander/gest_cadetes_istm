<?php 

    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
     
    $result = NULL;
    $linha = NULL;

    
    function BuscarClasse($Id = NULL , $Buscar = NULL , $Estado = NULL, $conexao)
    {
        
       
            if(@$conexao){

                $query = "SELECT * FROM tb_turma WHERE estado_turma = 1 AND ano LIKE :classe";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_turma 
                                WHERE estado_turma = 1 
                                AND id_turma = :id LIMIT 1";
                endif;
                
                $result = @$conexao->prepare(@$query);
                
                if(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_STR);
                else:
                    $Buscar = "%".$Buscar."%";
                    $result -> bindParam(":classe", $Buscar, PDO::PARAM_STR);
                endif;

                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        return FALSE;
    }
    

    function VerificarClasse($Valor = NULL , $conexao)
    {
        
        
            if(@$conexao){

                $query = "SELECT * FROM tb_turma WHERE ano = :valor LIMIT 1 ";
                
                $result = @$conexao->prepare(@$query);
                
                $result -> bindParam(":valor", $Valor, PDO::PARAM_STR);;
               
                $result->execute(); 

                if($result->rowCount() > 0 )
                {
                    return $result;
                }
            }

        return FALSE;
    }
    

    function RecoverClasse($Id = NULL,$conexao)
    {

        if ( @$Id != NULL ):

            if(@$conexao){

                $query = "UPDATE tb_turma SET estado_turma = 1 WHERE estado_turma = 0 AND id_turma = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarClasse( $Id, NULL, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function AddClasse($Classe = NULL, $conexao)
    {
        
        if ( @$Classe != NULL ):

            if(@$conexao){

                $Exists = VerificarClasse($Classe , $conexao);
                
                if($Exists):
                    
                    $dados = $Exists->fetchObject();
                    
                    if( $dados->estado_turma === "0"):
                        
                        $result = RecoverClasse($dados->id_turma , $conexao) ;
                        
                        if($result->rowCount() > 0 )
                        {
                            return $result;
                        }
                        
                    endif;
                else:

                    $query = "INSERT INTO tb_turma (id_turma, ano, estado_turma) values (DEFAULT, :classe , DEFAULT)";
                    $result = @$conexao->prepare(@$query);
                    $result -> bindParam(":classe", $Classe, PDO::PARAM_STR);
                    $result->execute();

                    if($result->rowCount() > 0 )
                    {
                        $result = BuscarClasse( $conexao->lastInsertId(), NULL, $conexao);
                        return $result;
                    }
                    
                endif;
            }

        endif;

        return FALSE;
    }

    function DeleteClasse($Id = NULL ,$conexao)
    {

        if ( @$Id != NULL ):

            if(@$conexao){

                $query = "UPDATE tb_turma SET estado_turma = 0 WHERE estado_turma = 1 AND id_turma = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    return TRUE;
                }
            }

        endif;

        return FALSE;
    }

    function UpdateClasse($Id = NULL, $Classe = NULL,$conexao)
    {

        if ( @$Curso != NULL ):

            if(@$conexao){

                $query = "UPDATE tb_turma SET ano = :classe WHERE estado_turma = 1 AND id_turma = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":classe", $Classe, PDO::PARAM_STR);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    $result = BuscarClasse($Id, NULL, $conexao);
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    if ( in_array(DecodificarTexto($pagina) ,["formclasse","viewclasses"]) ):
        switch( $btn ):
            case 'add':
                //echo "Caso: Add";
                $Insered = AddClasse( NULL ,$conexao);
                break;

            case 'delete':
                //echo "Caso: Delete";
                DeleteClasse($id_d,$conexao);
                break;

            case 'update':
                //echo "Caso: Update";
                UpdateClasse($id, NULL, $conexao);
                break;

            case 'recover':
                //echo "Caso: Recover";
                RecoverClasse($id ,$conexao);
                break;

            case 'buscar':
                //echo "Caso: Recover";
                BuscarClasse($id,$buscar, $estado, $conexao);
                break;

            default:
                //echo "Caso Padrão";
                break;
        endswitch;
    endif;
?>
