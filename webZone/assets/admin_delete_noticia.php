<?php

if(!isset($_SESSION)){
    session_start();
    
  }
    include '../includes/conexao.php';
    

    if(isset($_POST['delete-noticia'])){

        $noticia_id = $_POST['delete-noticia'];

        $sql = "DELETE FROM noticias WHERE id = :id";
        $stmt = $pdo ->prepare($sql);
        $stmt -> bindParam(':id', $noticia_id, PDO::PARAM_INT);
        

        if($stmt -> execute()){
            echo "<script> alert ('Noticia eliminada com sucesso!'); location.href = '../index.php';</script>";
            exit();
        }else{
            echo "<script> alert ('Não foi possível eliminar a noticia!'); location.href = '../index.php';</script>";
            exit();
        }
    }
    $pdo = null;