<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Produtos</title>
  <style>
    /* Estilo geral da página */
    body {
      font-family: 'Garamond', serif;
      background-color: #E07AB1;
      display: flex;
      flex-direction: column; /* Garante que a mensagem apareça abaixo do card */
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    /* Card/Container do formulário */
    .form-card {
      background-color: #79D6E0;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
    }

    .form-card h1 {
      text-align: center;
      color: #E07AB1;
      margin-top: 0;
      margin-bottom: 24px;
      font-size: 24px;
    }

    /* Grupos de campos */
    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      color: #E07AB1;
      font-weight: 600;
      margin-bottom: 6px;
      font-size: 14px;
    }

    .form-group input {
      width: 100%;
      padding: 10px 14px;
      border: 1.5px solid #79D6E0;
      border-radius: 6px;
      font-size: 15px;
      box-sizing: border-box;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    /* Destaque ao clicar no campo */
    .form-group input:focus {
      outline: none;
      border-color: #E0D479;
      box-shadow: 0 0 0 3px rgba(0, 131, 216, 0.15);
    }

    /* Estilo do botão */
    .btn-submit {
      width: 100%;
      padding: 12px;
      background-color: #E0D479;
      color: #ffffff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.2s ease, transform 0.1s ease;
      margin-top: 10px;
    }

    .btn-submit:hover {
      background-color: #006bb8;
    }

    .btn-submit:active {
      transform: scale(0.99);
    }

    /* Espaçamento simples para a mensagem do PHP */
    .php-mensagem {
      margin-top: 20px;
      font-weight: bold;
      font-size: 18px;
      text-align: center;
    }
  </style>
</head>
<body>

  <form class="form-card" method="post" action="">
    <h1>Cadastro de Produtos</h1>

    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" placeholder="Digite o nome do produto" required>
    </div>

    <div class="form-group">
      <label for="preço">Preço:</label>
      <input type="number" id="preço" name="preço" placeholder="Digite o preço do produto" step="0.01" required>
    </div>

    <button type="submit" class="btn-submit">Cadastrar</button>
  </form>
  
  <div class="php-mensagem">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $preço = $_POST['preço'];

        // Ajustado para os padrões do Apache local do Windows
        $servername = "localhost"; 
        $username = "root";
        $password = "Senai@118";
        $dbname = "exercicio";

        // Inicializa a conexão de forma segura
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("<span style='color: red;'>Falha na conexão: Verifique se o seu servidor MySQL está ativado.</span>");
        }

        // Restaura as configurações de exibição para erros de tabelas ou SQL
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $sql = "INSERT INTO produtos (nome, preco) VALUES ('$nome', '$preço')";


        if ($conn->query($sql) === TRUE) {
            echo "<span style='color: green;'>Produto cadastrado com sucesso!</span>";
        } else {
            echo "<span style='color: red;'>Erro ao cadastrar: " . $conn->error . "</span>";
        }

        $conn->close();
    }
    ?>
  </div>

</body>
</html>
