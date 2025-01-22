<?php include '../includes/conexao.php';  
if(!isset($_SESSION)){
  session_start();
  
}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title></title>
    <!--<style>
        .container{
          max-width: 1250px;
          margin: 0 auto;
          padding: 20px;
        }

        .links{
          display: flex;
          justify-content: space-around;
          background-color: #333;
          padding: 10px 0;
          list-style: none;
          margin: 0;
          border-radius: 8px;
        }
        .links li{
          margin: 0;
        }
        a.items{
          margin : 10px;
        }
        .items:hover, .items.active{
          background-color: #00d2ff;
          color: #000;
        }

        .conteudo-admin{
          
          margin-top: 20px;
          padding: 20px;
          background-color: rgba(255, 255, 255, 0.05);
          border: 1px solid #ddd;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }






        
        
    </style>-->
  </head>
  <body>
    <div class="container">
      <ul class="links"  >
      <li>
          <a
            class="items"
            href="assets/editar_admin"
            >Perfil Admin</a>
        </li>
        <li>
          <a
            class="items active"
            href="assets/consulta_utilizadores"
            >Consultar Utilizadores</a>
        </li>
        <li>
          <a
            class="items"
            href="assets/consulta_projetos"
            >Projetos</a>
        </li>
        <li>
          <a
            class="items"
            href="assets/consulta_noticias"
            >Notícias</a
          >
        </li>
        <li>
          <a
            class="items"
            href="assets/consulta_orcamentos"
            >Consultar Orçamentos</a
          >
        </li>
        <li>
          <a
            class="items"
            href="assets/consulta_mensagens"
            >Mensagens</a
          >
        </li>
      </ul>
      </section>

      <!--Secção de carregamento -->

      <section class="conteudo-admin" id="conteudo-admin">
       
      </section>
      </div>
      <script>

        /*Eventos para carregamento dinamico secções Administrador */
        $(document).ready(function(){
            $('#conteudo-admin').load('assets/consulta_utilizadores.php');

            $("li a.items").not('.page-link').click(function(e){
                
                e.preventDefault();
                $("li a").removeClass("active"); //Remover a classe 'active' de todos
                $(this).addClass("active"); //adicionar a classe 'active' no item clicado

                let page = $(this).attr("href"); //Obter o valor href
                $("#conteudo-admin")
                    .load(page + ".php", function(response, status, xhr){
                      if(status == 'error'){
                        console.log('Erro ao carregar o conteúdo solicitado.');
                      }else{
                        console.log('Pagina carregada com sucesso!');
                      }
                    });
            });


        })
      </script>
  </body>
</html>