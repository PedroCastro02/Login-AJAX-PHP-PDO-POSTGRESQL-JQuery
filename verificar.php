<?php
header('Content-Type: application/json');

require 'config.php';

$email = filter_input(INPUT_POST, 'email');
$senha = filter_input(INPUT_POST, 'password');

if (!empty($email) && !empty($senha)) {


        $sql = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];
        if(password_verify($senha, $hashed_password)) {
            echo json_encode(array('redirect' => 'lobby.php'));
        } else {
            echo json_encode("Usuário ou senha não encontrada.");
        }
    }
}
?>
