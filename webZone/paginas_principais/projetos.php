<?php 
  include '../includes/conexao.php';
  
  if(!isset($_SESSION)){
    session_start();
    
  }

  try {
    // Obter dados dos projetos
    $sql = "SELECT * FROM projetos  ORDER BY id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao consultar projetos: " . htmlspecialchars($e->getMessage()));
}
$pdo = null;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
  </head>
  <body>   
      <div class="projetos">   
        <?php if($projetos): $i= 0;?> 
        <?php foreach($projetos as $projeto): ?>
          <div class="projeto">
            <a href="<?=$projeto['imagem_path'];?>" class="example-image-link"        data-lightbox="example-1" data-title="<?=$projeto['titulo'];?>">
              <img style="margin-right: 20px" class="example-image" src="<?=$projeto['imagem_path'];?>" alt="<?= 'Imagem do projeto' . htmlspecialchars($projeto['titulo'])?>"/>
              <p><span>Dados do Projeto:</span><?=$projeto['dados_projeto']?></p>
              <p><span>Tecnologias: </span><?=$projeto['tecnologia']?>
              </p>
              <p><span>Tempo de conclusão: </span><?=$projeto['tempo_conclusao']?></p>
            </a>
            </div>
            <?php $i++;  if($i > 4){ break;} endforeach; ?>
          
        <?php else: ?>
            <p  class="mensagem">Não existem projetos em base de dados</p>
        <?php endif; ?>
          
          
            
      </div>
  </body>
</html>
