<?php 
    include './includes/conexao.php';
    if(!isset($_SESSION)){
      session_start();
      
    }
    
    //ver se utilizador tem o login realizado
    if (!isset($_SESSION['username']) || !isset($_SESSION['nome'])){
      $erro['unlog'] = 'Erro por favor realize o login.';
      
  }

    $is_logged = isset($_SESSION['username']);
    $user_type = $is_logged ? $_SESSION['user_type'] : '';
    $user_nome =  $is_logged ? $_SESSION['nome'] : '';
    $user_apelido = $is_logged  ? $_SESSION['apelido'] : '';
    
  
  $erros = [];
  $data_atual = date('Y-m-d');
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = htmlspecialchars(trim($_POST['nome']));
    $apelido = htmlspecialchars(trim($_POST['apelido']));
    $telemovel = htmlspecialchars(trim($_POST['telemovel']));
    $email = htmlspecialchars(trim($_POST['email']));
    $data_mensagem = htmlspecialchars(trim($_POST['data']));
    $mensagem = htmlspecialchars(trim($_POST['mensagem']));
  

    if(empty($nome) || empty($apelido) || empty($telemovel) || empty($email) || empty($data_mensagem) || empty($mensagem)){
      $erros[] = 'Por favor preencha todos os campos.';
    }

    if(strlen($nome) < 2){
      $erros[] = 'O Nome deve conter no minimo 2 caracteres.';
    }
    if(strlen($apelido) < 2){
      $erros[] = 'O Apelido deve conter no minimo 2 caracteres.';
    }
    if(strlen($telemovel) < 1|| strlen($telemovel) > 9 || !is_numeric($telemovel)){
      $erros[] = 'O Telemóvel deve conter 9 algarismos.';
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $erros[] = 'Por favor introduza um email válido';
    }
    if($data_mensagem !== $data_atual){
      $erros[] = 'Por favor introduza a Data de hoje';
    }
    if(strlen($mensagem) === 0 || strlen($mensagem)  > 500){
      $erros[] = 'A sua Mensagem deve conter no máximo 500 caracteres';
    }

    if(empty($erros)){

      $sql_verif = "SELECT * FROM utilizadores WHERE email = :email";
      $stmt_verif = $pdo ->prepare($sql_verif);
      $stmt_verif -> bindParam(':email', $email, PDO::PARAM_STR);
      $stmt_verif -> execute();

      if($stmt_verif->rowCount() > 0){

        $user_reg = $stmt_verif->fetch(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO mensagens (nome, apelido, telemovel, email, user_type, data, mensagem) VALUES (:nome, :apelido, :telemovel, :email, :user_type, :data, :mensagem)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt -> bindParam(':apelido', $apelido, PDO::PARAM_STR);
        $stmt -> bindParam(':telemovel', $telemovel, PDO::PARAM_STR);
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> bindParam(':user_type', $user_reg['user_type'], PDO::PARAM_STR);
        $stmt -> bindParam(':data', $data_mensagem, PDO::PARAM_STR);
        $stmt -> bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
        $mensagem = $stmt -> execute();
      }else{

          $sql = "INSERT INTO mensagens (nome, apelido, telemovel, email, data, mensagem) VALUES (:nome, :apelido, :telemovel, :email, :data, :mensagem)";
          $stmt = $pdo -> prepare($sql);
          $stmt -> bindParam(':nome', $nome, PDO::PARAM_STR);
          $stmt -> bindParam(':apelido', $apelido, PDO::PARAM_STR);
          $stmt -> bindParam(':telemovel', $telemovel, PDO::PARAM_STR);
          $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
          $stmt -> bindParam(':data', $data_mensagem, PDO::PARAM_STR);
          $stmt -> bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
          $mensagens = $stmt -> execute();
      }
      if($mensagens){
        echo "<script> alert('A sua mensagem foi enviada com sucesso!'); location.href = 'index.php'; </script>";
        
        exit();
      }elseif($mensagem){
        echo "<script> alert('A sua mensagem foi enviada com sucesso!'); location.href = 'index.php'; </script>";
      }else{
        echo "<script>alert('Não foi possível enviar a sua mensagem. Por favor tente mais tarde!'); location.href = 'index.php'; </script>";
          
        exit();
      }
    }
  }
$pdo = null;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Este é Portfolio com carregamento dinâmido de conteúdo estático através de AJAX"
    />
    <meta name="author" content="Fábio Ceriaco" />
    <!--css externo-->
    <link rel="stylesheet" href="./style/estilos.css" />
    <!--lightbox css-->
    <link rel="stylesheet" href="style/lightbox.min.css" />
    <!--GoogleFonts-->
    <link
      href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <!--Fontawesome-->
    <script
      src="https://kit.fontawesome.com/1cb2397d0b.js"
      crossorigin="anonymous"
    ></script>
    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!--Google Maps-->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOSBZbsi5s9IO2rPuGA7Ni13Qhn1pU6M0&callback=initMap"async defer
    ></script>
    <!--lightbox script-->
    <script src="script/lightbox-plus-jquery.min.js"></script>
    <!--FavIcon da página-->
    <link rel="icon" type="image/x-icon" href="image/favicon.png" />
    <title>Portfolio Fábio Ceriaco</title>
  
  </head>
  <body >
    <nav id="navBar">
      <div class="hamburger">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
      </div>
      <ul class="nav-links"  >
        <li>
          <a
            class="nav-item active"
            href="paginas_principais/sobre"
            >Sobre</a>
        </li>
        <li>
          <a
            class="nav-item"
            href="paginas_principais/projetos"
            >Projetos</a>
        </li>
        <li>
          <a
            class="nav-item"
            href="orcamentos"
            >Pedido de Orçamentos</a
          >
        </li>
        <?php if($user_type === 'cliente'):?>
        <li id="userNav">
          <a
            class="nav-item"
            href="assets/editar_user"
            id="pag-utilizador"
            >Area Cliente</a
          >
        </li>
        <li>
          <a
            class="nav-item"
            href="assets/consulta_orcamentos_utilizador"
            >Os meus Orçamentos</a
          >
        </li>
        <li><p>Bem-vindo, <?=$user_nome?> <?=$user_apelido?>!</p></li>
        <?php endif;?>
        <?php if($user_type === 'admin'):?>
        <li id="adminNav" >
          <a class="nav-item" href="assets/admin_page" id="pag-admin" 
            >Area Admin</a
          >
        </li>
        <li><p>Bem-vindo, <?=$user_nome?> <?=$user_apelido?>!</p></li>
        <?php endif;?>
        <?php  if($is_logged):?>
        <li>
          <input
            type="button"
            class="log-btn"
            href="logout.php"
            id="logout"
            value="Logout"
            
          />
        </li>
        <?php else:?>
          <li>
          <input
            class="log-btn"
            id="login"
            type="button"
            value="Login/Sign in"
          />
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <!--Header da página-->
    <header class="header">
      <div class="titulo">
        <h1>WebZone</h1>
      </div>
    </header>
    <!--Corpo da página-->
    <main class="corpo-pag">
      
      <section class="login-box" id="login-box">
        <span class="close-btn" id="closeLogin">&times;</span>
        <h2 id="logtitle">Login</h2>
        <form action="login.php" id="loginForm" method="post">
          <input
            type="text"
            name="username"
            placeholder="Nome de Utilizador"
            required
          />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
          <p>
            Se não e cliente no nosse site registe-se
            <a
              href="registo.php"
              class="nav-item"
              id="link-registo"
              >AQUI</a
            >
          </p>
          <input type="submit" name="submit" id="log-button" value="Entrar" />
        </form>
      </section>

      <!--Secção de carregamento -->

      <section class="conteudo" id="conteudo">
       
      </section>

      <!--Carregamento de noticias base de dados-->
      <section class="noticias" id="noticias">
          <h2 class="noticias-title">Últimas Notícias</h2>
            <?php include './includes/carregar_noticias.php'; if($noticias): $i= 0;?>
          <?php foreach($noticias as $noticia): ?>
            <article class="noticia">
                <img src="<?= $noticia['imagem_path'] ?>" alt="<?= 'Imagem da Noticia: ' . htmlspecialchars($noticia['titulo'])?>" class="noticia-img">
                <div class="noticia-conteudo">
                    <h3 class="titulo-noticia"><?=$noticia['titulo']?></h3>
                    <p class="noticia-desc">
                        <?= $noticia['descricao']?>
                    </p>
                    <a href="noticias.php?id=<?=$noticia['id']?>" class="noticia-link" id="noticia-link" data-id="<?=$noticia['id']?>">Leia mais</a>
                </div>
            </article>
            <?php $i++;  if($i > 4){ break;} endforeach; ?>
          
        <?php else: ?>
            <p style="color: red;">Não existem noticias em base de dados</p>
        <?php endif; ?>
      </section>
    <section class="contacto">
        <div class="contacto-header">
          <h2>Contactos</h2>
        </div>
        <div class="contacto-info">
          <div class="contactos">
            <p><i class="fas fa-location-pin"></i> Rua B, Nº 200, Évora</p>
            <p><i class="fas fa-phone"></i> +351 266 785 965</p>
            <p>
              <i class="fas fa-envelope"></i
              ><a href="mailto:exemplo@exemplo.com">exemplo@exemplo.com</a>
            </p>
          </div>
          <div class="map" id="mapa"></div>
        </div>
        
        <form class="contacto-form" method="post" action="">
          <?php 
            if(!empty($erros)){
              foreach($erros as $erro){
                echo "<span style='color: red; font-size: 0.7rem;'>". $erro . "</span>";
              }
            }
            ?>
          <div id="identificação">
            <div class="input-contacto">
              <label for="nome">Nome</label>
              <input id="nome" name="nome" type="text" placeholder="Nome" value="<?= isset($_POST['nome'])? $_POST['nome'] : ''?>"/>
            </div>
            <div class="input-contacto">
              <label for="apelido">Apelido</label>
              <input
                id="apelido"
                name="apelido"
                type="text"
                placeholder="Apelido"
                value="<?= isset($_POST['apelido'] )? $_POST['apelido'] : ''?>"
              />
            </div>
          </div>
          <div id="contactos">
            <div class="input-contacto">
              <label for="telemovel">Telemóvel</label>
              <input
                id="telemovel"
                name="telemovel"
                type="text"
                placeholder="Telemóvel"
                value="<?= isset($_POST['telemovel']) ? $_POST['telemovel'] : ''?>"
              />
            </div>
            <div class="input-contacto">
              <label for="email">Email</label>
              <input
                id="email"
                name="email"
                autocomplete="email"
                type="email"
                placeholder="Email"
                style="margin: 0"
                value="<?= isset($_POST['email']) ? $_POST['email'] : ''?>"
              />
            </div>
          </div>
          <div class="input-contacto">
            <label for="data">Data</label>
            <input id="data" name="data" type="date" value="<?= isset($_POST['data']) ? $_POST['data'] : '';?>"/>
          </div>
          <div class="input-contacto" style="margin: 0">
            <label for="mensagem">Mensagem</label>
            <textarea
              name="mensagem"
              id="mensagem"
              placeholder="Escreva aqui a sua mensagem"
            ></textarea>
            <br />
          </div>
          
          <button type="submit" id="contacto-btn">Enviar</button>
         
        </form>
        
      </section>
    </main>
    <!--Footer com redes sociais-->
    <footer>
      <div class="redes-sociais">
        <a href="#" target="_blank"
          ><i class="fa fa-instagram"></i
        ></a>
        <a href="#" target="_blank"
          ><i class="fa-brands fa-x-twitter"></i
        ></a>
        <a href="#" target="_blank"
          ><i class="fa fa-facebook" aria-hidden="true"></i
        ></a>
      </div>
      <p id="author">Powered by Fábio Ceriaco</p>
    </footer>
            <!--Script externo-->
    <script type="text/javascript" src="./script/script.js"></script>
  </body>
</html>
