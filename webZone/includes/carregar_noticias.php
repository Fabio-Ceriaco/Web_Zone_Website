<?php
    if(!isset($_SESSION)){
        session_start();
        
      }
    include 'conexao.php';
    

    try{
        $sql = "SELECT * FROM noticias ORDER BY id DESC";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute();
        $noticias = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $e){
        die("Erro ao consultar noticias: " . htmlspecialchars($e->getMessage()));
    }

$pdo = null;
    