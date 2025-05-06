<?php


$hostname = "localhost";
$username = "root";
$password = "";
$database = "ecommerce_senac";


$conn = new mysql($hostname, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

header('Content-Type: application/json'); 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':

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
    default:
        echo json_encode(["message" => "Método não suportado"]);
}

$conn->close();
?>
