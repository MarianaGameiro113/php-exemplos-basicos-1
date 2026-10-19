<?php   

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

// Consulta para buscar todos os clientes da tabela
$sql = "SELECT id, nome, email from clientes";
$result = $conn->query($sql);

// Verifica se existem registros e os exie em formato de tabela
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "  <tr>
                <th>ID</th>
                <th>Email</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";



    }
    echo "</table>";
} else {
    echo "Nenhum cliente encontrado.";
}

// Fecha a conexão
$conn->close();


?>