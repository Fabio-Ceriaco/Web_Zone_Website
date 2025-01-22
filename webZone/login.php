<?php
include './includes/conexao.php'; // Inclui a conexão com o banco de dados

if(!isset($_SESSION)){
    session_start();
    
  }

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
    try{
        $sql_verify = "SELECT user_id, user_type, nome, apelido, username, email, password FROM utilizadores WHERE username = :username";
        $stmt_verify = $pdo -> prepare($sql_verify);
        $stmt_verify -> bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_verify -> execute();
        $user = $stmt_verify -> fetch(PDO::FETCH_ASSOC);

        if($user){

        
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['apelido'] = $user['apelido'];
                echo "<script> location.href = 'index.php';</script>";
            }else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta!'); window.location.href = 'index.php';</script>";
            }
        } else {
            // Usuário não encontrado
            echo "<script>alert('Utilizador não encontrado!'); window.location.href = 'index.php';</script>";
        }
    }catch(PDOException $e){
        error_log("Erro no autenticação: " . $e -> getMessage());
        echo "<script>alert('Erro ao preocessar o login. Tente novamente mais tarde.'); location.href = 'index.php';</script>";
    }finally{
        $pdo = null;
    }
   
}







    