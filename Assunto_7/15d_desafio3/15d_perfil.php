<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: 15d_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
</head>
<body style="background-color: <?php echo $_SESSION['cor']; ?>;">

    <h2>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h2>
    <p>Esta é sua página de perfil.</p>

    <a href="15d_logout.php">Sair</a>

</body>
</html>
