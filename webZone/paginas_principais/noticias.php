<?php 

    include '../includes/conexao.php';
    if(!isset($_SESSION)){
        session_start();
       
      }
    
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
        echo "<script>alert ('Noticia não existe.'); location.href = '../index.php';</script>";
        exit();
    }
    $pdo = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--<style>
        .mais-noticia{
            background-color:  rgba(10, 10, 10, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        .mais-noticia h2{
            font-size: 24px;
            margin-bottom: 10px;
        }
        .mais-noticia-img{
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 10px 0;
        }
        .mais-noticia span{
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 15px;
        }
        .mais-noticia p{
            font-size: 16px;
            line-height: 1.6;
            text-align: left;
            
        }

        @media(max-width: 480px){

            .mais-noticia h2{
            font-size: 20px;
            
            } 
            .mais-noticia p{
            font-size: 14px;
            
            }
            .mais-noticia-img{
            border-radius: 5px;
            
            }
        }
    </style>-->
</head>
<body>
    <section class="mais-noticia">
        <?php if($noticia):?>
            <input type="hidden" name="id" value="<?= $noticia['id'] ?>">
            <h2><?= $noticia['titulo'] ?></h2>
            <img src="<?= $noticia['imagem_path'] ?>" alt="<?= 'Imagem da Noticia: ' . htmlspecialchars($noticia['titulo'])?>" class="mais-noticia-img">
            <span><?= $noticia['data']?></span>
            <p><?= $noticia['noticia']?></p>
        <?php endif;?>
    </section>
</body>
</html>