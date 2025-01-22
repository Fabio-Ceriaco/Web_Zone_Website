<?php

if(!isset($_SESSION)){
    session_start();
   
  }
    include '../includes/conexao.php';
    

    if(isset($_POST['delete-user'])){

        $user_id = $_POST['delete-user'];

        $sql = "DELETE FROM utilizadores WHERE user_id = :user_id";
        $stmt = $pdo ->prepare($sql);
        $stmt -> bindParam(':user_id', $user_id, PDO::PARAM_INT);
        

        if($stmt -> execute()){
            echo "<script> alert ('Utilizador eliminado com sucesso!'); location.href = '../index.php';</script>";
            exit();
        }else{
            echo "<script> alert ('Não foi possível eliminar o utilizador!'); location.href = '../index.php';</script>";
            exit();
        }
    }
    $pdo = null;