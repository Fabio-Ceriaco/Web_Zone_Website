<?php 
if(!isset($_SESSION)){
    session_start();
    
  }
include '../includes/conexao.php';
    
    
    // Verifica se há um 'id' de utilizador para editar
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID da mensagem não especificado.']);
    exit();
}
    $mensagem_id = $_GET['id'];

    // Preparar consulta aos dados do projeto com o 'id'
        $sql = 'SELECT * FROM mensagens WHERE id = :mensagem_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mensagem_id', $mensagem_id, PDO::PARAM_INT);
        $stmt->execute();
        $mensagem = $stmt->fetch(PDO::FETCH_ASSOC);
   
    // Se o usuário não existir, redireciona com erro
    if (!$mensagem) {
        echo "<script>alert ('Mensagem não existe.'); location.href = '../index.php';</script>";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
            echo "<script>alert('Mensagem enviada com sucesso!'); location.href= '../index.php';</script>";

        }
            
    

    
    $pdo = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
    <!--<style>
            #profileForm,
            #form-projetos, 
            .form-noticias,
            .form-mensagem{
            background-color: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            }
            #profileForm h2, 
            #form-projetos h2, 
            .form-noticias h2,
            .form-mensagem h2{
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
            
            #profileForm input,
            #opcao, 
            #form-projetos input, 
            .form-noticias input,
            .form-mensagem input {
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
            .form-mensagem  textarea {
            color: black;
            font-family: "Roboto", sans-serif;
            font-size: 1rem;
            padding-left: 0.75rem;
            width: 100%;
            border-radius: 5px;
            resize: none;
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
                .form-noticias h2,
                .form-mensagem h2{
                    font-size: 1.25rem;
                }
                #profileForm,
                #form-projetos, 
                .form-noticias,
                .form-mensagem{
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
                .form-noticias h2,
                .form-mensagem h2{
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
    
<form  method="post" class="form-mensagem" id="form-mensagem"  action="assets/responder_mensagem.php?id=<?= $mensagem['id'] ?>">
          <h2>Responder Mensagem</h2><br>
          <input type="hidden" name="id" value="<?= $mensagem['id'] ?>">
          <label for="id">ID:</label>
          <input type="text" id="id" name="id" value="<?= $mensagem['id'] ?>" readonly><br>
          <label for="funcao">Função:</label>
          <input type="text" id="funcao" name="funcao" value="<?= $mensagem['user_type'] ?>" readonly><br>
          <label for="nome"> Nome:</label>
          <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($mensagem['nome']) ?>" readonly/>
          <br />
          <label for="apelido"> Apelido:</label>
          <input type="text" name="apelido" id="apleido" value="<?= htmlspecialchars($mensagem['apelido']) ?>" readonly/>
          <br />
          <label for="email"> Email:</label>
          <input type="email" name="email" id="email" value="<?= htmlspecialchars($mensagem['email']) ?>" readonly/>
          <br />
          <label for="mensagem">Mensagem:</label>
          <textarea type="text" name="mensagem" id="mensagem" rows="10"></textarea>
          <br />
          
          <input type="submit" value="Enviar mensagem" class="sub-mensagem" />
        </form>
</body>
</html>