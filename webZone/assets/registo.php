<?php 

include '../includes/conexao.php';

if(!isset($_SESSION)){
  session_start();
 
}
//verificar se os dados do formulário foram enviados via POST
$erro = []; //array que armazena os erros
$resposta = []; //array que armazena a resposta final

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //dados do formulário
    $user_type = 'cliente';
    $nome = htmlspecialchars(trim($_POST['nome']));
    $apelido = htmlspecialchars(trim($_POST['apelido']));
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telefone = htmlspecialchars(trim($_POST['telefone']));
    $password = htmlspecialchars(trim($_POST['password']));
    $cpassword = htmlspecialchars(trim($_POST['cpassword']));
    
     // Validar campos obrigatórios
     if (empty($nome) || empty($apelido) || empty($username) || empty($email) || empty($telefone) || empty($password)) {
        $erro['campos'] = 'Por favor, preencha todos os campos obrigatórios.';
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $erro['email'] = 'O endereço de e-mail introduzido não é válido!';
    }
    if(strlen($telefone) < 9 || !is_numeric($telefone)){
      $erro['telefone'] = 'Contato telefónico invalido, deve ter no minimo 9 algarismos!';
    }
    if(strlen($password) < 8 || strlen($password) > 16){
      $erro['passwword'] = 'A password deve ter entre 8 a 16 caracteres!';
    }
    if($password !== $cpassword){
      $erro ['passwords'] = 'As password devem ser iguais!';
    }

    if(count($erro) === 0 ){
        // verificar se o e-mail ou username já existe
      $stmt = $pdo -> prepare("SELECT * FROM utilizadores WHERE email = :email OR username = :username" );
      $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
      $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
      $stmt -> execute();
    

        if($stmt -> rowCount() > 0){
            $erro['existe'] = 'Username ou e-mail já registados na base de dados!';
        }else{
            //criptografa a password
          $hashed_password = password_hash($password, PASSWORD_BCRYPT);

          //Inserir os dados na base de dados
          $stmt = $pdo -> prepare("INSERT INTO utilizadores (user_type, nome, apelido, username, email, telefone, password) VALUES (:user_type,:nome, :apelido, :username, :email, :telefone, :password)");
          $stmt -> bindParam(':user_type', $user_type, PDO::PARAM_STR);
          $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
          $stmt -> bindParam(':apelido', $apelido, PDO::PARAM_STR);
          $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
          $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
          $stmt -> bindParam(':telefone', $telefone,PDO::PARAM_STR);
          $stmt -> bindParam(':password', $hashed_password, PDO::PARAM_STR);
          $stmt -> execute();

          $resposta['sucesso'] = 'Registo realizado!';
        }

    
    
    }
    $resposta['errors'] = $erro;
    echo json_encode($resposta);
    exit();
    

}
$pdo = null;
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portfolio Fábio Ceriaco</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--<style>
            .form-noticias, 
            .form-registo{
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .form-noticias h2, 
            .form-registo h2{
            font-size: 1.8rem;
            font-family: "Orbitron", sans-serif;
            color: #00d2ff;
            text-align: center;
            margin-bottom: 1rem;
            }
            .form-noticias label, 
            .form-registo label{
            font-size: 1.5em;
            font-family: "Roboto", sans-serif;
            text-align: left;
            display: block;
            margin: 1rem 0 0.5rem;
            font-weight: bold;
            }

            .form-noticias  input, 
            .form-noticias  textarea,
            .form-registo input {
            border-radius: 5px;
            padding: 0.75rem;
            width: 95%;
            color: black;
            font-family: "Roboto", sans-serif;
            border: 1px solid #ccc;
            font-size: 1rem;
            }
             input[type='file']{
                border: none;
                padding: 0;
             }
             .form-noticias  textarea{
                resize: vertical;
                min-height: 120px;
             }
            
            input.sub-noticia, 
            input.sub-registo {
            background-color: #00d2ff;
            color: #0a0a0a;
            width: 100%;
            text-decoration: none;
            font-size: 1.1rem;
            margin: 1.5rem auto;
            border-radius: 5px;
            box-shadow: 0 0 15px #00d2ff;
            cursor: pointer;
            padding: 0.75rem;
            transition: background-color 0.3s;
            }
            .sub-noticia:hover,
            .sub-registo:hover{
                background-color: #00a3cc;
            }
            @media(max-width: 768px){
                .form-noticias, 
                .form-registo{
                    padding: 1.5rem;
                }
                .form-noticias h2, 
                .form-regist h2{
                    font-size: 1.5rem;
                }
                .form-noticias label, 
                .form-registo label{
                    font-size: 0.9rem;
                }
                .form-noticias  input, 
                .form-noticias  textarea,
                .form-registo input{
                    font-size: 0.9rem;
                }
                input.sub-noticia,
                input.sub-registo{
                    font-size: 1rem;
                }
            }
            @media(max-width: 480px){
                .form-noticias h2, 
                .form-regist h2{
                    font-size: 1.2rem;
                }
                .form-noticias label, 
                .form-registo label{
                    font-size: 0.85rem;
                }
                .form-noticias  input, 
                .form-noticias  textarea,
                .form-registo input{
                    font-size: 0.85rem;
                }
                input.sub-noticia,
                input.sub-registo{
                    font-size: 0.9rem;
                }
            }
    </style>-->
  </head>
 
  <body>
    
        <form  method="post" class="form-registo" id="form-registo">
          <h2>Registo de utilizador</h2><br>
          <div id="error-message"></div>
          <label for="nome"> Nome:</label>
          <input type="text" name="nome" id="nome" value="<?= isset($_POST['nome']) ? $_POST['nome'] : '';?>" required />
          <br />
          <label for="apelido">Apelido</label>
          <input type="text" name="apelido" id="apelido" value="<?= isset($_POST['apelido']) ? $_POST['apelido'] : '';?>"   required />
          <br />
          <label for="username">User Name</label>
          <input type="text" name="username" id="username" value="<?= isset($_POST['username']) ? $_POST['username'] : '';?>"  required/>
          <br />
          <label for="email">Email</label>
          <input type="email" name="email" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '';?>" required/>
          <br />
          <label for="telefone">Telefone</label>
          <input type="text" name="telefone" id="telefone" value="<?= isset($_POST['telefone']) ? $_POST['telefone'] : '';?>"  required />
          <br />
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required />
          <br />
          <label for="cpassword">Confirmar Password</label>
          <input type="password" name="cpassword" id="cpassword" required />
          <br />
          <input type="submit" value="Enviar dados" class="sub-registo" />
        </form>

        <script>

          /*Evento de erros para registo de utilizador */
          $(document).ready(function (){
            $('#form-registo').on('submit', function(e){
              e.preventDefault();//prvenir o envio padrão do formulário

              let formData = $(this).serialize(); //atribuir um numero de série aos dados do formulário

              $.ajax({
                type: 'POST',
                url: 'assets/registo.php',
                data: formData,
                dataType: 'json',
                success: function(response){
                  //Limpar mensagens de erro anteriores
                  $('#error-message').html('');

                  if(response.sucesso){
                    alert(response.sucesso);
                    //Redirecionar após sucesso
                    window.location.href = 'index.php';
                  }else if(response.errors){
                    let errorMessage = '';
                    $.each(response.errors, function(key, value){
                      errorMessage += '<p style="color: red;">'+value+'</p>';
                    });
                    $('#error-message').html(errorMessage);
                  }
                },
                error: function (){
                  alert('Erro ao processar a requisição!');
                }
              });
            });
          });
        </script>
  </body>
</html>
