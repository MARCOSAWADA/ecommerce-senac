<?php
header('Content-Type: application/json');


$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'ecommerce_senac';

$conn = new mysql($host, $user, $password, $database);


if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro na conexão com o banco de dados.']);
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $sql = "SELECT * FROM usuario";
        $result = $conn->query($sql);

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        echo json_encode($usuarios);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['nome'], $data['email'], $data['senha'], $data['telefone'], $data['cep'], $data['cpf'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados incompletos.']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, telefone, cep, cpf) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $data['nome'], $data['email'], $data['senha'], $data['telefone'], $data['cep'], $data['cpf']);

        if ($stmt->execute()) {
            echo json_encode(['mensagem' => 'Usuário inserido com sucesso.']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao inserir usuário.']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['erro' => 'Método não permitido.']);
}
?>
