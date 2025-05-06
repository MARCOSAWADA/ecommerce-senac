<?php
$servername = "localhost"; // Endereço do servidor de banco de dados
$username = "root";        // Nome de usuário do banco de dados
$password = "";            // Senha do banco de dados
$dbname = "ecommerce";     // Nome do banco de dados

// Criando conexão com o banco de dados
$conn = new mysql($servername, $username, $password, $dbname);

// Verificando se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Definindo o tipo de resposta da API
header('Content-Type: application/json');

// Lógica de manipulação da API
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Seleção de todos os usuários
        $sql = "SELECT * FROM usuario";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
            echo json_encode($usuarios);
        } else {
            echo json_encode([]);
        }
        break;
    
    case 'POST':
        // Inserção de um novo usuário
        $data = json_decode(file_get_contents('php://input'), true);
        
        $nome = $conn->real_escape_string($data['nome']);
        $email = $conn->real_escape_string($data['email']);
        $senha = password_hash($conn->real_escape_string($data['senha']), PASSWORD_DEFAULT);
        $telefone = $conn->real_escape_string($data['telefone']);
        $cep = $conn->real_escape_string($data['cep']);
        $cpf = $conn->real_escape_string($data['cpf']);
        
        $sql = "INSERT INTO usuario (nome, email, senha, telefone, cep, cpf) 
                VALUES ('$nome', '$email', '$senha', '$telefone', '$cep', '$cpf')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Usuário cadastrado com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao cadastrar usuário: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["message" => "Método não suportado"]);
}

$conn->close();
?>
