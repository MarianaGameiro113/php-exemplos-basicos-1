<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpLoad de imagens</title>
</head>
<body>
    <h2>Formulário de UpLoad</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <p>
            <label for="imagem">Selecione uma imagem:</label><br>
            <input type="file" name="imagem" id="imagem" required>
        </p>
        <button type="submit">Fazer UpLoad</button>
    </form>
    <div class="mensagem">

<?php 
    // Se foto enviada via formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Pasta de destino (das imagens)
        $diretorio_destino = 'uploads/';

        // Cria a pasta (se ela não existir)
        if(!is_dir($diretorio_destino)) {
            // O "0777" é um código que permite fazer CRUD completo
            // O "true" habilita a criação de sub-pastas
            mkdir($diretorio_destino, 0777, true);
        }

        // Verifica se a imagem existe e se não houve erro no envio
        if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            // Pega o nome do arquivo (Exemplo: Sabrina.jpg)
            $nome_arquivo = basename($_FILES['imagem']['name']);

            // Caminho completo (Exemplo: uploads/Sabrina.jpg)
            $caminho_completo = $diretorio_destino . $nome_arquivo;

            // Movendo a imagem para pasta (uploads)
            if(move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_completo)) {
                echo "<p>Upload realizado com sucesso!</p>";
                echo "<img src='$caminho_completo' alt='Imagem enviada' style='max-width: 300px;'>";
            } else {
                echo "<p>Erro ao fazer upload do arquivo!</p>";
            } }else {
                echo "<p>Nenhum arquivo enviado/ erro de upload!</p>";
            }
        }
    

?>
    
</body>
</html>