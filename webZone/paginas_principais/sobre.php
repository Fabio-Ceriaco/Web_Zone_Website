<?php
  include '../includes/conexao.php';
  
  if(!isset($_SESSION)){
    session_start();
    
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--<style>
      .sobre {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        width: 90%;
        padding: 20px;
        max-width: 1400px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        text-align:center;
      }
      .sobre h2 {
        font-family: "Orbitron", sans-serif;
        color: #00d2ff;
        font-size: 2.5em;
        margin-bottom: 20px;
      }
      .sobre > p {
        font-family: "Roboto", sans-serif;
        text-align: justify;
        font-size: 1.2em;
        line-height: 1.6;
        margin: 10px 0;
      }
      @media(max-width: 600px){
        .sobre h2{
          font-size: 1.8em;
        }
        .sobre p{
          font-size: 1em;
          margin: 5px 0;
        }
      }
    </style>-->
</head>
<body>
        <div class="sobre">
          <h2>Sobre a empresa...</h2>
          <p>
            Criada em 2024, especializada na criação de websites de alta
            performance, totalmente adaptados às necessidades do seu negócio.
            Desde websites institucionais a plataformas de e-commerce,
            garantimos que o seu site é rápido, seguro e escalável. Na WebZone
            não nos limitamos apenas à criação de websites, mas ao
            desenvolvimento de plataformas personalizadas e aplicações web que
            respondam a necessidades específicas de cada cliente.
          </p>
        </div>
</body>
</html>