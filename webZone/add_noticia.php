<?php 

include './includes/conexao.php';

if(!isset($_SESSION)){
  session_start();
  
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_FILES['image'])){
  $imagem = $_FILES['image'];
  $titulo = htmlspecialchars(trim($_POST['titulo']));
  $descricao = htmlspecialchars(trim($_POST['descricao']));
  $noticia = htmlspecialchars(trim($_POST['corpo-noticia']));
  

  if (empty($titulo) || empty($noticia) ) {
    echo "<script>alert('Todos os campos são obrigatórios.'); location.href = 'index.php';</script>";
    exit;
    }

  if($imagem['error']){
    echo "<script>alert('Erro ao enviar arquivo.'); location.href = 'index.php';</script>";
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
    echo "<script>alert('Tipo de extensão não aceite. Use JPG, PNG ou WEBP.'); location.href = '../index.php';</script>";
        exit;
  }
  $path = $pasta . $novoNomeArquivo . "." . $extensao;
  $certo = move_uploaded_file($imagem['tmp_name'], $path);

  if($certo){
    try{

    
    $sql = "INSERT INTO noticias (titulo, nome_original_imagem, imagem_path, descricao, noticia) VALUES (:titulo, :nome_original_imagem, :imagem_path, :descricao, :noticia) ";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $stmt -> bindParam(':nome_original_imagem', $nomeArquivo, PDO::PARAM_STR);
    $stmt -> bindParam(':imagem_path', $path, PDO::PARAM_STR);
    $stmt -> bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt -> bindParam(':noticia', $noticia, PDO::PARAM_STR);
    
    $stmt -> execute();
        echo "<script>alert('Noticia guardada com sucesso.'); location.href = 'index.php';</script>";
    }catch (PDOException $e){
        echo "<script>alert('Erro ao guardar noticia na base de dados: " . $e->getMessage() . "'); location.href = 'index.php';</script>";
        echo $e->getMessage();
    }


  }else{
    echo "<script>alert('Falha ao guardar o arquivo.'); location.href = 'index.php';</script>";

    }
}
$pdo = null;