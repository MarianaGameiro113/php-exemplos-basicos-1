<!-- Passar id via URL -->
<!-- http://localhost/php-basicos/12_atualizar.php?id=1-->


<?php

// Conecta ao banco de dados

$servername = "localhost";
$username = "root" ;
$password = "Senai@118";
$dbname =  "exercicio" ;

$conn = new mysqli ($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inicializa a variavel $cliente como null
$cliente = null;

// Verifica se um ID foi passado via URL para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE id='$id'";
    $result = $conn->query($sql);

    // Verifica se encontrou um registro no banco de dados
    if ($result->num_rows > 0) {
        $clientes = $result->fetch_assoc();
    } else {
        echo "Cliente não encontrado.";
        exit();
    }
}

// Verifica se o formulário foi enviado para atualizar o cliente

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST ['id'];
    $nome = $_POST ['nome'];
    $email = $_POST ['email'];

    $sql = "UPDATE clientes SET nome='$nome', email='$email' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Cliente atualizado com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar cliente: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-r">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $cliente['id'] ?? ''; ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo isset($cliente['nome']) ? $cliente ['nome'] : ''; ?>" require><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($cliente['email']) ? $cliente['email'] : ''; ?>" require><br>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>