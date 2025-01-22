<?php

if(!isset($_SESSION)){
    session_start();
    
  }
    include '../includes/conexao.php';
    

    if(isset($_POST['delete-orcamento'])){

        $orcamento_id = $_POST['delete-orcamento'];

        $sql = "DELETE FROM orcamentos WHERE id = :id";
        $stmt = $pdo ->prepare($sql);
        $stmt -> bindParam(':id', $orcamento_id, PDO::PARAM_INT);
        

        if($stmt -> execute()){
            echo "<script> alert ('Orçamento eliminado com sucesso!'); location.href = '../index.php';</script>";
            exit();
        }else{
            echo "<script> alert ('Não foi possível eliminar o orçamento!'); location.href = '../index.php';</script>";
            exit();
        }
    }
    $pdo = null;