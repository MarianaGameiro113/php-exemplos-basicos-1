<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <!-- Formulário -->
    <form method="post" action="">
        <!-- Campo nome -->
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <!-- Campo senha -->
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>

        <!-- Botão de cadastro -->
        <button type="submit">Cadastrar</button>
    </form>
    <!-- Lógica para gravar as informações -->
<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os valores enviados do front-end
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    //Lógica para gravar os dados em um arquivo txt

    // O Fopen significa "file open" ou abir arquivo e a letra "a" significa "append" ou acrescentar
    $arquivo = fopen('usuarios.txt', 'a');

    // Cria uma linha com o nome e a senha separados por ";"
    $linha = $nome . ';' . $senha . "\n";

    // Escreve a linha no arquivo
    fwrite($arquivo, $linha);

    // Fecha o arquivo
    fclose($arquivo);

    //redireciona para a própria página (após cadastro)
    header ('Location: ' .$_SERVER['PHP_SELF']. '?sucesso=1');
    exit;
}
if(isset($_GET['sucesso'])){
    //Mensagem ou feedback visual para o usuário
    echo "<p>Usuário cadastrado com sucesso!</p>";

    //Comunica para o front-end e atualiza após 3 segundos
    header('Refresh; 3; url=' .$_SERVER ['PHP_SELF']);

    }
?>

</body>
</html>