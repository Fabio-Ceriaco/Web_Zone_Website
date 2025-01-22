<?php include '../includes/conexao.php'; 
if(!isset($_SESSION)){
    session_start();
    
  }?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--<style>
        /*Formulário registo de projetos*/

            .form-noticias {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .form-noticias h2 {
            font-size: 1.8rem;
            font-family: "Orbitron", sans-serif;
            color: #00d2ff;
            text-align: center;
            margin-bottom: 1rem;
            }
            .form-noticias label {
            font-size: 1.5em;
            font-family: "Roboto", sans-serif;
            text-align: left;
            display: block;
            margin: 1rem 0 0.5rem;
            font-weight: bold;
            }

            .form-noticias  input, 
            .form-noticias  textarea {
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
            
            input.sub-noticia {
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
            .sub-noticia:hover{
                background-color: #00a3cc;
            }
            @media(max-width: 768px){
                .form-noticias{
                    padding: 1.5rem;
                }
                .form-noticias h2{
                    font-size: 1.5rem;
                }
                .form-noticias label{
                    font-size: 0.9rem;
                }
                .form-noticias  input, 
                .form-noticias  textarea{
                    font-size: 0.9rem;
                }
                input.sub-noticia{
                    font-size: 1rem;
                }
            }
            @media(max-width: 480px){
                .form-noticias h2{
                    font-size: 1.2rem;
                }
                .form-noticias label{
                    font-size: 0.85rem;
                }
                .form-noticias  input, 
                .form-noticias  textarea{
                    font-size: 0.85rem;
                }
                input.sub-noticia{
                    font-size: 0.9rem;
                }
            }
    </style>-->
</head>
<body>
<form  method="post" class="form-noticias" id="form-noticias" enctype="multipart/form-data" action="add_noticia.php">
          <h2>Publicação de Noticia</h2><br>
          
          <label for="titulo"> Titulo:</label>
          <input type="text" name="titulo" id="titulo" />
          <br />
          <label for="image">Imagem:</label>
          <div class="image">
          <input type="file" name="image" id="image" style="margin-top: 0.25rem;;" />
          </div>
          <label for="descricao"> Descrição:</label>
          <input type="text" name="descricao" id="descricao" />
          <br />
          <label for="corpo-noticia">Corpo da Noticia:</label>
          <textarea name="corpo-noticia" id="corpo-noticia" cols="8" rows="10"></textarea>
          <br />
          
          
          <input type="submit" value="Enviar dados" class="sub-noticia" />
        </form>
</body>
</html>