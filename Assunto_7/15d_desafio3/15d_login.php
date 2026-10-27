<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Desafio 3 - Login</title>
</head>
<body>
    <h2>Login</h2>

    <form method="post" action="">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>

        <label for="cor">Cor de Fundo:</label>
        <select name="cor" required>
            <option value="lightblue">Azul Claro</option>
            <option value="lightgreen">Verde Claro</option>
            <option value="lightcoral">Vermelho Claro</option>
            <option value="lightyellow">Amarelo Claro</option>
        </select><br>

        <button type="submit">Entrar</button>
    </form>

    <?php
    session_start();

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recebe os valores enviados pelo formulário
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $cor = $_POST['cor'];

        // Conecta ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "Senai@118";
        $dbname = "exercicio";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Consulta o usuário no BD
        $sql = "SELECT * FROM usuarios 
                WHERE usuario = '$usuario' AND senha = '$senha'";

        $result = $conn->query($sql);

        // Verifica se encontrou o usuário
        if ($result->num_rows > 0) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['cor'] = $cor;

            header("Location: 15d_perfil.php");
            exit();
            // echo "<script>
            //         window.location.href = '15d_perfil.php';
            //       </script>";
        } else {
            echo "<p style='color: red;'>Usuário ou senha incorretos!</p>";
        }

        // Fecha a conexão
        $conn->close();
    }
    ?>
</body>
</html>
