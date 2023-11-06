<?php

    $host = 'localhost'; // Endereço do servidor do banco de dados
    $port = '5432'; // Porta do banco de dados (normalmente 5432 para PostgreSQL)
    $dbname = 'Marmoraria'; // Nome do banco de dados
    $usuario = 'postgres'; // Nome de usuário do banco de dados
    $senha = 'postgres'; // Senha do banco de dados

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$usuario;password=$senha");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }