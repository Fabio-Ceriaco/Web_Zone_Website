<?php 
if(!isset($_SESSION)){
    session_start();
    
  }
include './includes/conexao.php';
    
    
    // Verifica se há um 'id' de utilizador para editar
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID da noticia não especificado.']);
    exit();
}
    $projeto_id = $_GET['id'];

    // Preparar consulta aos dados do projeto com o 'id'
        $sql = 'SELECT * FROM projetos WHERE id = :projeto_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':projeto_id', $projeto_id, PDO::PARAM_INT);
        $stmt->execute();
        $projeto = $stmt->fetch(PDO::FETCH_ASSOC);
   
    // Se o usuário não existir, redireciona com erro
    if (!$projeto) {
        echo "<script>alert ('Projeto não existe.'); location.href = 'index.php';</script>";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $titulo = htmlspecialchars(trim($_POST['titulo']));
        $dados_projeto = htmlspecialchars(trim($_POST['dados_projeto']));
        $tecnologia = htmlspecialchars(trim($_POST['tecnologia']));
        $temp_conclusao = htmlspecialchars(trim($_POST['tempo_conclusao']));
        if (empty($titulo) || empty($dados_projeto) || empty($tecnologia) || empty($temp_conclusao)){
            echo "<script>alert('Todos os campos são obrigatórios.'); location.href = 'index.php';</script>";
            exit;
            }

            try{
                
                if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
                
                    $imagem = $_FILES['image'];
                    $titulo = htmlspecialchars(trim($_POST['titulo']));
                    $dados_projeto = htmlspecialchars(trim($_POST['dados_projeto']));
                    $tecnologia = htmlspecialchars(trim($_POST['tecnologia']));
                    $temp_conclusao = htmlspecialchars(trim($_POST['tempo_conclusao']));
                  
                    if (empty($titulo) || empty($dados_projeto) || empty($tecnologia) || empty($temp_conclusao)){
                        echo "<script>alert('Todos os campos são obrigatórios.'); location.href = 'index.php';</script>";
                        exit;
                        }
                  
                    
                  
                    if($imagem['size'] > 2097152){
                      echo "<script>alert('Arquivo muito grande. Max: 2MB'); location.href = 'index.php';</script>";
                          exit;
                    }
                  
                    $pasta = "image_projetos/";
                    $nomeArquivo = $imagem['name'];
                    $novoNomeArquivo = uniqid();
                    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
                  
                    if($extensao != 'jpg' && $extensao != 'png' && $extensao != 'webp'){
                      echo "<script>alert('Tipo de extensão não aceita. Use JPG, PNG ou WEBP.'); location.href = '../index.php';</script>";
                          exit;
                    }
                    $path = $pasta . $novoNomeArquivo . "." . $extensao;
                    $certo = move_uploaded_file($imagem['tmp_name'], $path);
                  
                    if($certo){
                      
                        
                      $sql = "UPDATE  projetos SET titulo = :titulo, nome_original_imagem = :nome_original_imagem, imagem_path = :imagem_path, dados_projeto = :dados_projeto, tecnologia = :tecnologia, tempo_conclusao = :tempo_conclusao WHERE id = :projeto_id ";
                      $stmt = $pdo -> prepare($sql);
                      
                      $stmt -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
                      $stmt -> bindParam(':nome_original_imagem', $nomeArquivo, PDO::PARAM_STR);
                      $stmt -> bindParam(':imagem_path', $path, PDO::PARAM_STR);
                      $stmt ->bindParam(':dados_projeto', $dados_projeto, PDO::PARAM_STR);
                      $stmt -> bindParam(':tecnologia', $tecnologia, PDO::PARAM_STR);
                      $stmt -> bindParam(':tempo_conclusao', $temp_conclusao, PDO::PARAM_STR);
                      
                  
                    }else{
                      echo "<script>alert('Falha ao guardar o arquivo.'); location.href = 'index.php';</script>";
                  
                      }
                  }else{
                    $sql = "UPDATE  projetos SET titulo = :titulo, dados_projeto = :dados_projeto, tecnologia = :tecnologia, tempo_conclusao = :tempo_conclusao WHERE id = :projeto_id ";
                    $stmt = $pdo -> prepare($sql);
                    
                    $stmt -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
                    $stmt ->bindParam(':dados_projeto', $dados_projeto, PDO::PARAM_STR);
                    $stmt -> bindParam(':tecnologia', $tecnologia, PDO::PARAM_STR);
                    $stmt -> bindParam(':tempo_conclusao', $temp_conclusao, PDO::PARAM_STR);
                    

                  }
                  $stmt -> bindParam(':projeto_id', $projeto_id, PDO::PARAM_INT);
                  $stmt -> execute();
                    echo "<script>alert('Projeto alterado com sucesso.'); location.href = 'index.php';</script>";

            }catch (PDOException $e){
                echo "<script>alert('Erro ao alterar o projeto na base de dados: " . $e->getMessage() . "'); location.href = 'index.php';</script>";      
            }       
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
            /*#profileForm,
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
            }*/
    </style>-->
</head>
<body>
    
<form  method="post" class="form-projetos" id="form-projetos" enctype="multipart/form-data" action="editar_projetos.php?id=<?= $projeto['id'] ?>">
          <h2>Editar Projeto</h2><br>
          <input type="hidden" name="id" value="<?= $projeto['id'] ?>">
          <label for="id">ID:</label>
          <input type="text" id="id" name="id" value="<?= $projeto['id'] ?>" readonly><br>
          <label for="titulo"> Titulo:</label>
          <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($projeto['titulo']) ?>"/>
          <br />
          <label for="image">Imagem:</label>
          <div class="image">
          <input type="file" name="image" id="image" style="margin-top: 0.25rem;;" />
          </div>
          
          <br />
          <label for="dados_projeto">Dados Projeto:</label>
          <input type="text" name="dados_projeto" id="dados_projeto" value="<?= htmlspecialchars($projeto['dados_projeto']) ?>"/>
          <br />
          <label for="tecnologia">Tecnologia:</label>
          <input type="text" name="tecnologia" id="tecnologia" value="<?= htmlspecialchars($projeto['tecnologia']) ?>" />
          <br />
          <label for="tempo_conclusao">Tempo de conclusão:</label>
          <input type="text" name="tempo_conclusao" id="tempo_conclusao" value="<?= htmlspecialchars($projeto['tempo_conclusao']) ?>"  />
          <br />
          
          <input type="submit" value="Enviar dados" class="sub-projeto" />
        </form>
</body>
</html>