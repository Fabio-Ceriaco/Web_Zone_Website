<?php

if(!isset($_SESSION)){
    session_start();
    
  }
    include '../includes/conexao.php';
    

    if(isset($_POST['delete-pojeto'])){

        $projeto_id = $_POST['delete-pojeto'];

        $sql = "DELETE FROM projetos WHERE id = :id";
        $stmt = $pdo ->prepare($sql);
        $stmt -> bindParam(':id', $projeto_id, PDO::PARAM_INT);
        

        if($stmt -> execute()){
            echo "<script> alert ('Projeto eliminado com sucesso!'); location.href = '../index.php';</script>";
            exit();
        }else{
            echo "<script> alert ('Não foi possível eliminar o projeto!'); location.href = '../index.php';</script>";
            exit();
        }
    }
    $pdo = null;