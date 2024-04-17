<?php   is_file("./includes/config.php") 
            ? require_once("./includes/config.php") 
            : ( is_file("./../includes/config.php") 
                    ? require_once("./../includes/config.php") 
                    : Null 
               ) ; 
?>

<?php  // require_once("./includes/config.php")  ?>
<?php  //require_once("./../includes/config.php")  ?>

<?php
    
    $conexao = NULL;
    
    try {
        $conexao = new PDO("mysql:host=".@$servername.";dbname=".@$db, @$username, @$password);
        
        //$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // echo "Conectado Com Sucesso";

    } catch(PDOException $e) {
        $msg = $e->getMessage();
        echo "<script>alert('Falha Ao Conectar Com O Banco De Dados:')</script> ";
        // echo "Falha Ao Conectar Com O Banco De Dados: " . $e->getMessage();
    }

?>
