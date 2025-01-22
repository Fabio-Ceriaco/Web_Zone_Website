<?php 
  require './includes/conexao.php';
  
  
  if(!isset($_SESSION)){
    session_start();
    
  }
    $erros = [];
    $data_atual = date("Y-m-d H:i:s");
    
  
  
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = htmlspecialchars(trim($_POST['nome_orcamentos']));
    $apelido = htmlspecialchars(trim($_POST['apelido_orcamentos']));
    $email = htmlspecialchars(trim($_POST['email_orcamentos']));
    $telemovel = htmlspecialchars(trim($_POST['telemovel_orcamentos']));
    $tipo_pagina = htmlspecialchars(trim($_POST['opcao']));
    $meses = htmlspecialchars(trim($_POST['meses']));
    $extras = isset($_POST['extras'])? $_POST['extras'] : [];
    $valor_estimado = str_replace('€', '', htmlspecialchars(trim($_POST['total']))) ;
    $data_orcamento = $data_atual;
    
    
    
  

    if(empty($nome) || empty($apelido) || empty($telemovel) || empty($email)){
      $erros[] = 'Por favor preencha todos os campos.';
    }

    if(strlen($nome) < 2){
      $erros[] = 'O Nome deve conter no minimo 2 caracteres.';
    }
    if(strlen($apelido) < 2){
      $erros[] = 'O Apelido deve conter no minimo 2 caracteres.';
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $erros[] = 'Deve introduzir um e-mail válido.';
    }
    if(strlen($telemovel) < 1|| strlen($telemovel) > 9 || !is_numeric($telemovel)){
      $erros[] = 'O Telemóvel deve conter 9 algarismos.';
    }
    
    

    if(empty($erros)){
      $extras_total = json_encode($extras);
      $sql_verif = "SELECT * FROM utilizadores WHERE email = :email";
      $stmt_verif = $pdo ->prepare($sql_verif);
      $stmt_verif -> bindParam(':email', $email, PDO::PARAM_STR);
      $stmt_verif -> execute();
        

      if($stmt_verif->rowCount() > 0){
        $user_reg = $stmt_verif->fetch(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO orcamentos (nome, apelido, email, user_type, telemovel, tipo_pagina, meses, extras, valor_estimado, data_orcamento) VALUES (:nome, :apelido, :email, :user_type, :telemovel, :tipo_pagina, :meses, :extras, :valor_estimado, :data_orcamento)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt -> bindParam(':apelido', $apelido, PDO::PARAM_STR);
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> bindParam(':user_type', $user_reg['user_type'], PDO::PARAM_STR);
        $stmt -> bindParam(':telemovel', $telemovel, PDO::PARAM_STR);
        $stmt -> bindParam(':tipo_pagina', $tipo_pagina, PDO::PARAM_STR);
        $stmt -> bindParam(':meses', $meses, PDO::PARAM_INT);
        $stmt -> bindParam(':extras', $extras_total, PDO::PARAM_STR);
        $stmt -> bindParam(':valor_estimado', $valor_estimado, PDO::PARAM_STR);
        $stmt -> bindParam(':data_orcamento', $data_orcamento, PDO::PARAM_STR);
        $orcamentos = $stmt -> execute();
      }else{
        
        $sql = "INSERT INTO orcamentos (nome, apelido, email, telemovel, tipo_pagina, meses, extras, valor_estimado, data_orcamento) VALUES (:nome, :apelido, :email, :telemovel, :tipo_pagina, :meses, :extras, :valor_estimado, :data_orcamento)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt -> bindParam(':apelido', $apelido, PDO::PARAM_STR);
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> bindParam(':telemovel', $telemovel, PDO::PARAM_STR);
        $stmt -> bindParam(':tipo_pagina', $tipo_pagina, PDO::PARAM_STR);
        $stmt -> bindParam(':meses', $meses, PDO::PARAM_INT);
        $stmt -> bindParam(':extras', $extras_total, PDO::PARAM_STR);
        $stmt -> bindParam(':valor_estimado', $valor_estimado, PDO::PARAM_STR);
        $stmt -> bindParam(':data_orcamento', $data_orcamento, PDO::PARAM_STR);
        $orcamento = $stmt -> execute();
      }

      
      
      
      if($orcamento){
        echo "<script> alert('Orçamento enviado com sucesso. Entraremos em contato consigo! Obrigado.'); location.href = 'index.php' </script>";
        
        exit();
      }elseif($orcamentos){
        echo "<script> alert('Orçamento enviado com sucesso. Entraremos em contato consigo! Obrigado.'); location.href = 'index.php' </script>";
      }else{
        echo "<script>alert('Não foi possível enviar o seu orçamento. Por favor tente mais tarde!'); location.href = 'index.phpindex.php'; </script>";
          
        exit();
      }
    }
  }
$pdo = null;

