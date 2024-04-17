<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificando se o campo de nome de usuário e senha estão preenchidos
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Dados do banco de dados (substitua pelas suas informações)
        $servername = "seu_servidor";
        $username = "seu_usuario";
        $password = "sua_senha";
        $dbname = "seu_banco_de_dados";

        try {
            // Criando uma conexão com o banco de dados usando PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // Configurando o modo de erros para exceções
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Obtendo os dados do formulário
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Preparando a consulta para evitar SQL injection
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result !== false) {
                // Verificando se a senha está correta (você deve ter as senhas criptografadas no banco de dados)
                if (password_verify($password, $result['password'])) {
                    // Login bem-sucedido, definindo a variável de sessão para manter o estado de login
                    $_SESSION["user_id"] = $result['id'];
                    $_SESSION["username"] = $result['username'];
                    // Redirecionando para a página após o login bem-sucedido (por exemplo, a página do perfil)
                    header("Location: pagina_do_perfil.php");
                    exit();
                } else {
                    $error_message = "Senha incorreta!";
                }
            } else {
                $error_message = "Nome de usuário não encontrado!";
            }
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($error_message)) {
        echo "<p>$error_message</p>";
    } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Senha:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Entrar">
    </form>
</body>

</html>