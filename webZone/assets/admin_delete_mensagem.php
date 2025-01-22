<?php

if(!isset($_SESSION)){
    session_start();
    
  }
    include '../includes/conexao.php';
    

    if(isset($_POST['delete-mensagem'])){

        $noticia_id = $_POST['delete-mensagem'];

        $sql = "DELETE FROM mensagens WHERE id = :id";
        $stmt = $pdo ->prepare($sql);
        $stmt -> bindParam(':id', $noticia_id, PDO::PARAM_INT);
        

        if($stmt -> execute()){
            echo "<script> alert ('Mensagem eliminada com sucesso!'); location.href = '../index.php';</script>";
            exit();
        }else{
            echo "<script> alert ('Não foi possível eliminar a mensagem!'); location.href = '../index.php';</script>";
            exit();
        }
    }
    $pdo = null;