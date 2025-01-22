<?php

include '../includes/conexao.php';

if(!isset($_SESSION)){
    session_start();
    
  }


$erro = [];
$resposta = [];

// Verifica se há um 'id' de utilizador para editar
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID do utilizador não especificado.']);
    exit();
}

$user_id = $_GET['id']; // Recupera o ID do utilizador enviado pela URL

// Preparar consulta aos dados do utilizador com o 'id'
$sql = 'SELECT user_id, username, user_type, nome, apelido, email, telefone, password FROM utilizadores WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Se o usuário não existir, redireciona com erro
if (!$user) {
    echo json_encode(['error' => 'O utilizador não existe!']);
    exit();
}

// Processar a atualização dos dados quando o formulário é submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe os novos dados do formulário
    $nome = htmlspecialchars(trim($_POST['nome']));
    $apelido = htmlspecialchars(trim($_POST['apelido']));
    $username_update = htmlspecialchars(trim($_POST['username']));
    $user_type = htmlspecialchars(trim($_POST['user_type']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telefone = htmlspecialchars(trim($_POST['telefone']));
    

    // Validar campos obrigatórios
    if (empty($nome) || empty($apelido) || empty($username_update) || empty($email) || empty($telefone)) {
        $erro['campos'] = 'Por favor, preencha todos os campos obrigatórios.';
    }

    // Validar e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro['email'] = 'O endereço de e-mail não é válido!';
    }

    // Validar telefone
    if (strlen($telefone) < 9 || !is_numeric($telefone)) {
        $erro['telefone'] = 'Telefone inválido, deve ter no mínimo 9 algarismos!';
    }

    // Verificar se o e-mail ou username já existem (se foram modificados)
    if (($username_update !== $user['username'] || $email !== $user['email'])) {
        $stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE (email = :email OR username = :username) AND user_id != :user_id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username_update, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $erro['existe'] = 'Username ou e-mail já estão registrados.';
        }
    }

    // Verificar a password (se modificada)
    if (!empty($password)) {
        if (strlen($password) < 8 || strlen($password) > 16) {
            $erro['password'] = 'A senha deve ter entre 8 a 16 caracteres!';
        }
        if ($password !== $cpassword) {
            $erro['passwords'] = 'As senhas não coincidem!';
        }
    }

    // Se houver erros, retorna
    if (!empty($erro)) {
        $resposta['errors'] = $erro;
        echo json_encode($resposta);
        exit();
    }

    try {
        
        
            
            $sql = "UPDATE utilizadores SET user_type = :user_type, nome = :nome, apelido = :apelido, username = :username, email = :email, telefone = :telefone WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
        

        // Bind os parâmetros
        $stmt->bindParam(':user_type', $user_type, PDO::PARAM_STR);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':apelido', $apelido, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username_update, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // Executar a consulta
        if ($stmt->execute()) {
            $_SESSION['loggedInUser'] = $username_update;
            $resposta['sucesso'] = 'Dados atualizados com sucesso!';
        } else {
            $erro['erro_sql'] = 'Erro ao atualizar dados!';
        }

    } catch (PDOException $e) {
        $erro['exception'] = 'Erro no sistema: ' . $e->getMessage();
    }

    // Retornar erro ou sucesso
    $resposta['errors'] = $erro;
    echo json_encode($resposta);
    exit();
}
$pdo = null;
?>

<!-- Formulário HTML para edição do utilizador -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados do Utilizador</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--<style>
            #profileForm,
            #form-projetos, 
            .form-noticias{
            background-color: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
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

    <form action="assets/admin_edit_user.php?id=<?= $user['user_id'] ?>" id="profileForm" method="POST">
        <h2>Editar Dados do Utilizador</h2>
        <div id="error-message"></div>
        <br>
        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" value="<?= $user['user_id'] ?>" readonly><br>
        <label for="user_type">Tipo de utilizador:</label>
        <input type="text" id="user_type" name="user_type" value="<?= $user['user_type'] ?>" required><br>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= $user['nome'] ?>" required><br>

        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" value="<?= $user['apelido'] ?>" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?= $user['email'] ?>" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?= $user['telefone'] ?>" required><br>

        <input type="submit" value="Atualizar" id="sub-update"><br>
    </form>

    <script>

        /*Eventos para edição, adição e paginação edição utilizador */
        $(document).ready(function() {
            $('#profileForm').on('submit', function(e) {
                e.preventDefault(); // Previne o envio do formulário tradicional

                let formData = $(this).serialize(); // Serializa os dados do formulário

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'), // Envia para a própria página
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#error-message').html(''); // Limpar erros anteriores
                        if (response.sucesso) {
                            alert(response.sucesso); // Exibe sucesso
                            window.location.href = 'index.php'; // Redireciona após sucesso
                        } else {
                            let errorMessages = '';
                            $.each(response.errors, function(key, value) {
                                errorMessages += '<p>' + value + '</p>';
                            });
                            $('#error-message').html(errorMessages); // Exibe erros
                        }
                    },
                    error: function() {
                        alert('Erro ao processar a requisição!');
                    }
                });
            });
        });
    </script>

</body>
</html>
