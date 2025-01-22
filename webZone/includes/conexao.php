<?php 

    //conexao a Base de Dados

    $username = 'root';
    $password = '';
    $dsn = 'mysql:host=localhost;dbname=webzone;charset=utf8mb4';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //ativar exceções em erros 
        $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); //configuração padrão de fetch
        
    }catch (PDOException $e){
        die('Erro de conexão a Base de Dados: ' . $e -> getMessage());
    }