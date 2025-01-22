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
  $dados_projeto = htmlspecialchars(trim($_POST['dados_projeto']));
  $tecnologia = htmlspecialchars(trim($_POST['tecnologia']));
  $temp_conclusao = htmlspecialchars(trim($_POST['tempo_conclusao']));

  if (empty($titulo) || empty($dados_projeto) || empty($tecnologia) || empty($temp_conclusao)) {
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

  $pasta = "image_projetos/";
  $nomeArquivo = $imagem['name'];
  $novoNomeArquivo = uniqid();
  $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

  if($extensao != 'jpg' && $extensao != 'png'){
    echo "<script>alert('Tipo de extensão não aceita. Use JPG ou PNG.'); location.href = 'index.php';</script>";
        exit;
  }
  $path = $pasta . $novoNomeArquivo . "." . $extensao;
  $certo = move_uploaded_file($imagem['tmp_name'], $path);

  if($certo){
    try{

    
    $sql = "INSERT INTO projetos (titulo, nome_original_imagem, imagem_path, dados_projeto, tecnologia, tempo_conclusao) VALUES (:titulo, :nome_original_imagem, :imagem_path, :dados_projeto, :tecnologia, :tempo_conclusao) ";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $stmt -> bindParam(':nome_original_imagem', $nomeArquivo, PDO::PARAM_STR);
    $stmt -> bindParam(':imagem_path', $path, PDO::PARAM_STR);
    $stmt -> bindParam(':dados_projeto', $dados_projeto, PDO::PARAM_STR);
    $stmt -> bindParam(':tecnologia', $tecnologia, PDO::PARAM_STR);
    $stmt -> bindParam(':tempo_conclusao', $temp_conclusao, PDO::PARAM_STR);
    $stmt -> execute();
        echo "<script>alert('Projeto guardado com sucesso.'); location.href = 'index.php';</script>";
    }catch (PDOException $e){
        echo "<script>alert('Erro ao guardar projeto na base de dados: " . $e->getMessage() . "'); location.href = 'index.php';</script>";
    }


  }else{
    echo "<script>alert('Falha ao guardar o arquivo.'); location.href = 'index.php';</script>";

    }
}
$pdo = null;