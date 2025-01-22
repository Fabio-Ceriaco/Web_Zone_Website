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
    $noticia_id = $_GET['id'];

    // Preparar consulta aos dados do projeto com o 'id'
        $sql = 'SELECT * FROM noticias WHERE id = :noticia_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':noticia_id', $noticia_id, PDO::PARAM_INT);
        $stmt->execute();
        $noticia = $stmt->fetch(PDO::FETCH_ASSOC);
   
    // Se o usuário não existir, redireciona com erro
    if (!$noticia) {
        echo "<script>alert ('Noticia não existe.'); location.href = 'index.php';</script>";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $titulo = htmlspecialchars(trim($_POST['titulo']));
        $noticia = htmlspecialchars(trim($_POST['corpo-noticia']));
        if (empty($titulo) || empty($noticia)){
            echo "<script>alert('Todos os campos são obrigatórios.'); location.href = 'index.php';</script>";
            exit;
            }

            try{
                
                if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
                
                    $imagem = $_FILES['image'];
                    $titulo = htmlspecialchars(trim($_POST['titulo']));
                    $noticia = htmlspecialchars(trim($_POST['corpo-noticia']));
                  
                    if (empty($titulo) || empty($noticia)){
                        echo "<script>alert('Todos os campos são obrigatórios.'); location.href = 'index.php';</script>";
                        exit;
                        }
                  
                    
                  
                    if($imagem['size'] > 2097152){
                      echo "<script>alert('Arquivo muito grande. Max: 2MB'); location.href = 'index.php';</script>";
                          exit;
                    }
                  
                    $pasta = "image_noticias/";
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
                      
                        
                      $sql = "UPDATE  noticias SET titulo = :titulo, nome_original_imagem = :nome_original_imagem, imagem_path = :imagem_path, noticia = :noticia WHERE id = :noticia_id ";
                      $stmt = $pdo -> prepare($sql);
                      
                      $stmt -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
                      $stmt -> bindParam(':nome_original_imagem', $nomeArquivo, PDO::PARAM_STR);
                      $stmt -> bindParam(':imagem_path', $path, PDO::PARAM_STR);
                      $stmt -> bindParam(':noticia', $noticia, PDO::PARAM_STR);
                  
                    }else{
                      echo "<script>alert('Falha ao guardar o arquivo.'); location.href = 'index.php';</script>";
                  
                      }
                  }else{
                    $sql = "UPDATE  noticias SET titulo = :titulo,noticia = :noticia WHERE id = :noticia_id ";
                    $stmt = $pdo -> prepare($sql);
                    
                    $stmt -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
                    $stmt -> bindParam(':noticia', $noticia, PDO::PARAM_STR);
                    

                  }
                  $stmt -> bindParam(':noticia_id', $noticia_id, PDO::PARAM_INT);
                  $stmt -> execute();
                    echo "<script>alert('Noticia alterada com sucesso.'); location.href = 'index.php';</script>";

            }catch (PDOException $e){
                echo "<script>alert('Erro ao alterar noticia na base de dados: " . $e->getMessage() . "'); location.href = 'index.php';</script>";      
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
            width: 95%;
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
            }
    </style>-->
</head>
<body>
    
<form  method="post" class="form-noticias" id="form-noticias" enctype="multipart/form-data" action="editar_noticia.php?id=<?= $noticia['id'] ?>">
          <h2>Editar Noticia</h2><br>
          <input type="hidden" name="id" value="<?= $noticia['id'] ?>">
          <label for="id">ID:</label>
          <input type="text" id="id" name="id" value="<?= $noticia['id'] ?>" readonly><br>
          <label for="titulo"> Titulo:</label>
          <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>"/>
          <br />
          <label for="image">Imagem:</label>
          <div class="image">
          <input type="file" name="image" id="image" style="margin-top: 0.25rem;;" value="<?=$noticia['nome_original_imagem']?>"/>
          </div>
          
          <br />
          <label for="corpo-noticia">Corpo d noticia:</label>
          <textarea type="text" name="corpo-noticia" id="corpo-noticia" rows="10"><?= $noticia['noticia'] ?></textarea>
          <br />
          
          <input type="submit" value="Enviar dados" class="sub-noticia" />
        </form>
</body>
</html>