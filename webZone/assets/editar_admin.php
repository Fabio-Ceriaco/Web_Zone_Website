<?php
include '../includes/conexao.php';



if(!isset($_SESSION)){
    session_start();
    
  }

    $erro = [];
    $resposta = [];
    
    //ver se utilizador tem o login realizado
    if (!isset($_SESSION['username'])){
        $erro['unlog'] = 'Erro por favor realize o login.';
        
    }

    //obter username do utilizador

    $username = $_SESSION['username'];
   
    //preparar consulta do utilizador á base de dados

    $sql = 'SELECT username, nome, apelido, email, telefone , password FROM utilizadores WHERE username = :username';
    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
    $stmt -> execute();
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);

    if(!$user){
        //se o utilizador não existir redirecina para o index.php
        $erro['noUser'] = 'O utilizador não existe!';
        echo json_encode(['errors' => $erro]);
        exit();
        
    }



    //processar e atualizar os dados do utilizador

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //obter os novos dados do formulário 
            $nome = htmlspecialchars(trim($_POST['nome']));
            $apelido = htmlspecialchars(trim($_POST['apelido']));
            $username_update = htmlspecialchars(trim($_POST['username']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telefone = htmlspecialchars(trim($_POST['telefone']));
            $password = htmlspecialchars(trim($_POST['password']));
            $cpassword = htmlspecialchars(trim($_POST['cpassword']));

             // Validar campos obrigatórios
            if (empty($nome) || empty($apelido) || empty($username) || empty($email) || empty($telefone)) {
                $erro['campos'] = 'Por favor, preencha todos os campos obrigatórios.';
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $erro['email'] = 'O endereço de e-mail introduzido não é válido!';
            }
            if(strlen($telefone) < 9 || !is_numeric($telefone)){
                $erro['telefone'] = 'Contato telefónico invalido, deve ter no minimo 9 algarismos!';
            }

            if($username_update !== $user['username'] || $email !== $user['email']){
              // verificar se o e-mail ou username já existe
              $stmt = $pdo -> prepare("SELECT * FROM utilizadores WHERE (email = :email OR username = :username) AND username != :current_username" );
              $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
              $stmt -> bindParam(':username', $username_update, PDO::PARAM_STR);
              $stmt -> bindParam(':current_username', $username, PDO::PARAM_STR);
              $stmt -> execute();
              

              if($stmt -> rowCount() > 0){
                  $erro['existe'] = 'Username ou e-mail já registados na base de dados!';
              }
              
            }

                if(!empty($password)){
                    if(strlen($password) < 8 || strlen($password) > 16){
                        $erro['passwword'] = 'A password deve ter entre 8 a 16 caracteres!';
                    }
                    if($password !== $cpassword){
                        $erro ['passwords'] = 'As password devem ser iguais!';
                    }
                }
            
                //Interromper se houver erros

                if(!empty($erro)){
                    $resposta['errors'] = $erro;
                    echo json_encode($resposta);
                    exit();
                }
            
                try{
                    //se a password foi alterada, atualizar a senha
                if(!empty($password)){
                    

                    
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "UPDATE utilizadores SET nome = :nome, apelido = :apelido, username = :username, email = :email, telefone = :telefone, password = :password WHERE username = :username_original";
                    $stmt = $pdo -> prepare($sql);
                    
                    $stmt -> bindParam(':password', $hashed_password, PDO::PARAM_STR);
                    
                    
                }else{

                    //caso contrário, apenas atualizar os outros dados
                    $sql = "UPDATE utilizadores SET nome = :nome, apelido = :apelido, username = :username, email = :email, telefone = :telefone WHERE username = :username_original";
                    $stmt = $pdo -> prepare($sql);
                }
                    
                    
                    $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
                    $stmt -> bindParam(':apelido', $apelido, PDO::PARAM_STR);
                    $stmt -> bindParam(':username', $username_update, PDO::PARAM_STR);
                    $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt -> bindParam(':telefone', $telefone, PDO::PARAM_STR);
                    $stmt -> bindParam(':username_original', $username, PDO::PARAM_STR);
                    
                    //mensagens
                    if($stmt -> execute()){

                        if(!empty($password)){
                            //Realizar logout se a senha foi alterada
                            session_unset();
                            session_destroy();
                            $resposta['sucesso'] = 'Senha atualizada com sucesso. A redirecionar para a página inicial.';
                            $resposta['logout'] = true;
                        }else{
                            //atualizar a sessão com o novos dados
                            $_SESSION['username'] = $username_update;
                            $resposta['sucesso'] = 'Atualização dos dados realizada com sucesso!';
                            $resposta['logout'] = false;
                        }
                        
                        
                        
                    }else{
                        $erro['error'] = 'Atualização dos dados não foi realizada!'; 
                    }

                }catch (PDOException $e){
                    $erro['exception'] = 'Erro no sistema: ' . $e -> getMessage();
                }

                
              

            
            $resposta['errors'] = $erro;
            echo json_encode($resposta);
            exit();
        }
        $pdo = null;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados Pessoais</title>
   <!-- <style>
            #profileForm,
            #form-projetos, 
            .form-noticias{
            background-color: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            }
            #profileForm h2, 
            #form-projetos h2, 
            .form-noticias h2{
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-family: "Orbitron", sans-serif;
            color: #00d2ff;
            text-align: center;
            }
            label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #555;
            }
            .form-noticias  textarea {
            color: black;
            font-family: "Roboto", sans-serif;
            font-size: 1rem;
            padding-left: 0.75rem;
            width: 100%;
            border-radius: 5px;
            resize: none;
            }
            #profileForm input,
            #opcao, #form-projetos input {
            color: black;
            font-family: "Roboto", sans-serif;
            
            }
            input[type="text"],
            input[type="email"],
            input[type="tel"],
            input[type="submit"],
            input[type="number"],
            input[type="password"],
            #opcao {
            width: 95%;
            padding: 0.75rem;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            font-family: "Roboto", sans-serif;
            }
            #opcao > option {
            color: black;
            font-family: "Roboto", sans-serif;
            }

            #extras {
            display: flex;
            flex-direction: column;
            margin: 0;
            }
            #extras > h3 {
            font-size: 2em;
            font-family: "Orbitron", sans-serif;
            color: #00d2ff;
            margin-bottom: 10px;
            }
            .extra > label {
            font-size: 1.2em;
            font-family: "Roboto", sans-serif;
            }

            input[type="submit"] {
            background: #00d2ff;
            color: #0a0a0a;
            width: 50%;
            height: 3rem;
            text-decoration: none;
            font-size: 1rem;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 2rem;
            box-shadow: 0 0 15px #00d2ff;
            cursor: pointer;
            }
            input[type="submit"]:hover{
                background-color: #00a3cc;
            }
            #erro-message {
            color: red;
            margin-bottom: 10px;
            }
            @media(max-width: 768px){
                #profileForm h2, 
                #form-projetos h2, 
                .form-noticias h2{
                    font-size: 1.25rem;
                }
                #profileForm,
                #form-projetos, 
                .form-noticias{
                    padding: 1rem;
                }
                label{
                    font-size: 0.9rem;
                }
                input[type="submit"] {
                    font-size: 0.9rem;
                }
            }
            @media(max-width: 480px){
                #profileForm h2, 
                #form-projetos h2, 
                .form-noticias h2{
                    font-size: 1rem;
                }
                label{
                    font-size: 0.85rem;
                }
                input, textarea{
                    font-size: 0.85rem;
                }
                input[type="submit"] {
                    font-size: 0.85rem;
                    padding: 0.6rem;
                }
            }
    </style>-->
</head>
<body>
    
    <form action="" id="profileForm" method="post">
        <h2>Editar Dados Pessoais</h2>
        <div id="error-message"></div>
        <br>
        <input type="hidden" name="username" value="<?=$username?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $user['nome']; ?>" required><br>
        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" value="<?php echo $user['apelido']; ?>" required><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $user['telefone']; ?>" required><br>
        <label for="password">Nova Password (Deixar em branco para não alterar):</label>
        <input type="password" id="password" name="password">
        <br>
        <label for="cpassword">Repetir Password:</label>
        <input type="password" id="cpassword" name="cpassword">
        <br>
        <input type="submit" value="Atualizar" id="sub-update">
        <br>
    </form>
    <script>

        /*Eventos do editar Administrador */
        $(document).ready(function (){
            $('#profileForm').on('submit', function (e){
                e.preventDefault(); //previne o envio padrão do formulário

                let formData = $(this).serialize(); //atribuir um numero de série aos dados do formulário

                $.ajax({
                    type: 'POST',
                    url: 'assets/editar_user.php',
                    data: formData,
                    dataType: 'json',
                    success: function (response){
                        //Limpar mensagens de erro anteriores
                        $('#error-message').html('');

                        if(response.sucesso){
                            alert(response.sucesso);
                            //Redirecionar após sucesso
                            if(response.logout){
                                
                                    
                                    localStorage.removeItem('username');
                                    localStorage.removeItem('userType');
                                    window.location.href = 'index.php';
                                    
                                    
                                
                            }else{
                                window.location.href = 'index.php';
                            }
                            
                        }else if(response.errors){
                            let errorMessages = '';
                            $.each(response.errors, function (key, value){
                                errorMessages += '<p style="color: red;">' + value + '</p>';
                            });
                            $('#error-message').html(errorMessages);
                        }
                    },
                    error: function(){
                        alert('Erro ao processar a requisição!');
                    }
                });
            });
            
        });
    </script>
</body>
</html>
