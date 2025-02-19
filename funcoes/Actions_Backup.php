<?php 

    $btn =  DecodificarTexto( isset($_POST["btn"]) ? $_POST["btn"] : (isset($_GET["btn"]) ? $_GET["btn"] : NULL) ) ;

    $buscar = ( isset($_POST["nomebusca"]) ? $_POST["nomebusca"] : (isset($_GET["nomebusca"]) ? $_GET["nomebusca"] : NULL) );
    $id = (DecodificarTexto( isset($_POST["id"]) ? @$_POST["id"] : (isset($_GET["id"]) ? $_GET["id"] : NULL) ));
    $id_d = (DecodificarTexto( isset($_POST["id_d"]) ? @$_POST["id_d"] : (isset($_GET["id_d"]) ? $_GET["id_d"] : NULL) ));
    
	$admin = NULL;
	if( isset($nivel_cookie) & @$nivel_cookie == '1' & isset($permissao_cookie) & in_array(@$permissao_cookie , [1,2,3]) ):
		$admin = $_SESSION['id'];
	endif;

    $result = NULL;
    $linha = NULL;

    function CriarBackup( $DestinoBackup=NULL , $Admin=NULL , $conexao = NULL)
    {
        if(!is_dir(@$DestinoBackup)): mkdir(@$DestinoBackup); endif;

        $nomeBackup = @$DestinoBackup . 'bck_'.md5(uniqid((mt_rand().random_bytes(64).time()), true )).'_'.date('Ymd').".sql" ;

        // $cmd = "mysqldump -u root $db > $nomeBackup"; // Para Debian ou Windows Onde o MySQLDump já se encontra na Variável de Ambiente
        $cmd = "C:\\xampp\\mysql\\bin\\mysqldump -u root $db > $nomeBackup"; // Para Servidor Windows XAMPP onde o MySQLDump já se encontra na Variável de Ambiente

        shell_exec($cmd);
    }
    
    function Buscar($Id = NULL , $Buscar = NULL , $Admin = NULL, $conexao)
    {
        
        // Echo "Buscar -- ";
        
        if ( @$Admin != NULL):
            
            // Echo "Admin -- ";

            if(@$conexao){
                
                // Echo "Conectado -- ";

                $query = "SELECT * FROM tb_disciplina disciplina 
                            JOIN tb_admin admin 
                                ON admin.id_admin = disciplina.id_admin 
                            JOIN tb_pessoa pessoa 
                                ON pessoa.id_pessoa = admin.id_pessoa 
                            WHERE estado_disciplina = 1 
                            AND (disciplina.disciplina LIKE :buscar 
                            OR pessoa.nome_pessoa like :nomePessoa 
                            OR identidade_pessoa like :identidadePessoa ) ";
                
                if(@$Id != NULL ): 
                    $query = "SELECT * FROM tb_disciplina disciplina 
                                JOIN tb_admin admin 
                                    ON admin.id_admin = disciplina.id_admin 
                                JOIN tb_pessoa pessoa 
                                    ON pessoa.id_pessoa = admin.id_pessoa 
                                WHERE estado_disciplina = 1 
                                AND id_disciplina = :id LIMIT 1";
                endif;

                //var_dump($query);
                
                $result = @$conexao->prepare(@$query);
                
                if(@$Id != NULL): 
                    $result -> bindParam(":id", $Id, PDO::PARAM_STR);
                else:
                    $Buscar = "%".$Buscar."%";
                    $result -> bindParam(":buscar", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":nomePessoa", $Buscar, PDO::PARAM_STR);
                    $result -> bindParam(":identidadePessoa", $Buscar, PDO::PARAM_STR);
                endif;

                $result->execute(); 
                // Echo "Executado -- ";

                if($result->rowCount() > 0 )
                {
                    // Echo "Contagem -- ";
                    // var_dump( $result->fetchobject());
                    return $result;
                }
            }

        endif;

        return FALSE;
    }

    function Add($Admin = NULL, $conexao)
    {
        
        if ( @$Disciplina != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "INSERT INTO tb_disciplina VALUES (DEFAULT,:disciplina,:admin, NOW(), DEFAULT)";
                $query = "INSERT INTO tb_disciplina VALUES (DEFAULT,:disciplina,:admin, NOW(), 1)";
                $result = @$conexao->prepare(@$query);
                $result -> bindParam(":disciplina", $Disciplina, PDO::PARAM_STR);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    return TRUE;
                }
            }

        endif;

        return FALSE;
    }

    function Delete($Id = NULL , $Admin = NULL,$conexao)
    {

        if ( @$Id != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_disciplina SET estado_disciplina = 0 WHERE estado_disciplina = 1 AND id_disciplina = :id";
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

    function RestoreBackup($Id = NULL, $Admin = NULL,$conexao)
    {

        if ( @$Disciplina != NULL & @$Admin != NULL):

            if(@$conexao){

                $query = "UPDATE tb_disciplina SET estado_disciplina = 1, id_admin = :admin WHERE estado_disciplina = 0 AND id_disciplina = :id";
                $result = @$conexao->prepare($query);
                $result -> bindParam(":id", $Id, PDO::PARAM_INT);
                $result -> bindParam(":admin", $Admin, PDO::PARAM_INT);
                $result->execute();

                if($result->rowCount() > 0 )
                {
                    return TRUE;
                }
            }

        endif;

        return FALSE;
    }

    

    switch( $btn ):
        case 'add':
            //echo "Caso: Add";
            $Insered = Add($disciplina,$admin,$conexao);
            break;

        case 'delete':
            //echo "Caso: Delete";
            Delete($id_d,$admin,$conexao);
            break;

        case 'update':
            //echo "Caso: Update";
            Update($id, $disciplina, $admin ,$conexao);
            break;

        case 'recover':
            //echo "Caso: Recover";
            Recover($id, $disciplina, $admin ,$conexao);
            break;

        case 'buscar':
            //echo "Caso: Recover";
            Buscar($id,$buscar, $admin, $conexao);
            break;

        default:
            //echo "Caso Padrão";
            break;
    endswitch;
?>
