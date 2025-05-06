<?php

$host = 'localhost';
$db = 'mini_ecommerce';
$user = 'root';
$pass = ''; // coloque a senha do seu banco aqui

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro na conexão: ' . $e->getMessage()]);
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $stmt = $pdo->query("SELECT id, nome, email, telefone, cep, cpf FROM usuario");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
        break;

    case 'POST':
        $json = file_get_contents("php://input");
        $dados = json_decode($json, true);

        if (!$dados) {
            echo json_encode(['erro' => 'Dados JSON inválidos']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, senha, telefone, cep, cpf) VALUES (?, ?, ?, ?, ?, ?)");
        $senhaCriptografada = password_hash($dados['senha'], PASSWORD_DEFAULT);

        $resultado = $stmt->execute([
            $dados['nome'],
            $dados['email'],
            $senhaCriptografada,
            $dados['telefone'],
            $dados['cep'],
            $dados['cpf']
        ]);

        echo json_encode(['sucesso' => $resultado]);
        break;

    default:
        echo json_encode(['erro' => 'Método não suportado']);
        break;
}
