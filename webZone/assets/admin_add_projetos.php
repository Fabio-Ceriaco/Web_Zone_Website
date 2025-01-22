<?php include '../includes/conexao.php'; 
if(!isset($_SESSION)){
    session_start();
    
  } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form  method="post" class="form-projetos" id="form-projetos" enctype="multipart/form-data" action="add_projetos.php">
          <h2>Registo de Projeto</h2><br>
          
          <label for="titulo"> Titulo:</label>
          <input type="text" name="titulo" id="titulo" />
          <br />
          <label for="image">Imagem:</label>
          <div class="image">
          <input type="file" name="image" id="image" style="margin-top: 0.25rem;;" />
          </div>
          
          <br />
          <label for="dados_projeto">Dados Projeto:</label>
          <input type="text" name="dados_projeto" id="dados_projeto"/>
          <br />
          <label for="tecnologia">Tecnologia:</label>
          <input type="text" name="tecnologia" id="tecnologia" />
          <br />
          <label for="tempo_conclusao">Tempo de conclusão:</label>
          <input type="text" name="tempo_conclusao" id="tempo_conclusao"  />
          <br />
          
          <input type="submit" value="Enviar dados" class="sub-projeto" />
        </form>
</body>
</html>