<?php 
header('Content-Type: application/json');

include './connection/connection.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha = filter_input(INPUT_POST, 'password');

if ($email && $senha) {
    $sql = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $sql->bindValue(':email', $email);
    $sql->execute();

    $row = $sql->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verifica se a senha fornecida corresponde à senha armazenada no banco de dados
        if (password_verify($senha, $row['password'])) {
            echo json_encode(array('redirect' => 'home.php'));
        } else {
            echo json_encode(array('error' => 'Usuário ou senha incorreta.'));
        }
    } else {
        echo json_encode(array('error' => 'Usuário não encontrado.'));
    }
} else {
    echo json_encode(array('error' => 'Email ou senha inválidos.'));
}

?>
