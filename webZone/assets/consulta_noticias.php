<?php
if(!isset($_SESSION)){
    session_start();
    
  }
include '../includes/conexao.php';



// Verificar se o utilizador tem login e é admin
if (!isset($_SESSION['username']) || !isset($_SESSION['user_type'])) {
    echo "<script>alert('Sessão expirada ou não configurada!'); window.location.href = '../index.php';</script>";
    exit();
}


try {
    $sql_quantidade = "SELECT count(*) as c FROM noticias";
    $count_stmt = $pdo->prepare($sql_quantidade);
    $count_stmt -> execute();
    $sql_noticias_count = $count_stmt->fetch(PDO::FETCH_ASSOC);
    $noticias_count = $sql_noticias_count['c'];
    
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1 ;
    $limit = 3;
    $page_interval = 2;
    $offset = ($page - 1) * $limit;

    $num_page_ntc = ceil($noticias_count/$limit);
    // Obter dados do utilizador
    $sql = "SELECT * FROM noticias ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt ->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt -> bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erro ao consultar dados: " . htmlspecialchars($e->getMessage()));
}

$pdo = null;
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title></title> 
    <!--<style>

                /*tabela */
               .titulo h2 {
                    text-align: center;
                    font-size: 2rem;
                    color: white;
                    margin: 20px 0;
                }
                table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px auto;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                thead th{
                    background-color: gray;
                    color: white;
                    font-weight: bold;
                    padding: 10px;
                    text-align: left;
                }
                tbody td{
                    padding: 10px;
                    text-align: center;
                    border-bottom: 1px solid #ddd;
                }
                tbody tr:nth-child(even){
                    background-color: gray;
                }
                tbody tr:hover {
                background-color: gray;
                
                }

                .editar-noticia, .delete-btn{
                    display: inline-block;
                    padding: 5px 10px;
                    color:white;
                    border:none;
                    border-radius: 4px;
                    text-decoration: none;
                    font-size: 0.9rem;
                    transition: background-color 0.3s;
                    cursor: pointer;
                }
                .editar-noticia{
                    background-color: #4caf50;
                }
                .editar-noticia:hover{
                    background-color: #45a049;
                }
                .delete-btn{
                    background-color: #f44336;
                   
                }
                .delete-btn:hover{
                    background-color: #d32f2f;
                }
                img{
                    width: 50%;
                    height: 50%;
                    
                }
                .add-noticia{
                    display: block;
                    margin: 20px auto;
                    padding: 10px 20px;
                    background-color: #00d2ff;
                    font-size: 1rem;
                    border: none;
                    border-radius: 5px;
                    text-align: center;
                    cursor: pointer;
                    transition: background-color 0.3s; 
                }
                .add-noticia:hover{
                    background-color: #00a3cc;
                }
                #acoes{
                    display:table-cell;
                }
                #acoes button{
                    margin-left: 0;
                }
                p{
                    text-align: center;
                    margin: 1rem 1rem;
                }
                a.page-link-ntc{
                    text-decoration: none;
                    border: 1px solid;
                    border-radius: 5px;
                    padding: 5px;
                    margin-right: 0.2rem;
                    background-color: #00d2ff;
                    color: black;
                    font-weight: bold;
                    box-shadow: inset -3px 4px 3px 0px rgba(0, 0, 0, 0.3);
                }
                a.page-link-ntc:hover{
                    background-color: #00a3cc;
                }
                
                @media (max-width: 768px){
                    thead th, rbody td{
                        font-size: 0.9rem;
                        padding: 8px;
                    }
                    .editar-noticia, .delete-btn, .add-noticia{
                        font-size: 0.8rem;
                    }

                }
                @media (max-width: 480px){
                    table{
                        font-size: 0.8rem;
                        width: 100%;
                    }
                    .editar-btn, .delete-btn, .add-noticia{
                        font-size: 0.7rem;
                        padding: 5px 10px;
                    }
                }
                
    </style>-->
  </head>
  <body>
        
        <div class="titulo"><h2>Consultar Noticias</h2></div>
        <div class="tb-noticias">
        <table >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagem</th>
                    <th>Corpo Noticia</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($noticias): ?>
                    <?php foreach ($noticias as $noticia): ?>
                        <tr>
                        
                            
                                <td id="valor_id"><?= htmlspecialchars($noticia['id'])?></td>
                                <td id="valor_titulo"><?= htmlspecialchars($noticia['titulo'])?></td>
                                <td id="valor_imagem"><img
                                style="margin-right: 20px"
                                class="example-image"
                                src="<?= htmlspecialchars($noticia['imagem_path'])?>"
                                alt="image-1"
                                width="100%"
                                height="100%"/></td>
                                <td id="valor_dados"><?= htmlspecialchars($noticia['noticia'])?></td>
                                
                                
                                <td id="acoes">
                                    <div>
                                    <a class="editar-noticia" type="button"  href="editar_noticia.php?id=<?=$noticia['id']?>" data-id="<?=$noticia['id']?>" >Editar</a>
                                    <form action="assets/admin_delete_noticia.php" method="post">
                                    <button class="delete-btn" id="delete-btn" type="submit" name="delete-noticia" value="<?=$noticia['id'];?>" onclick="return confirm('Deseja eliminar esta Noticia?')">Delete</button>
                                    </form>
                                    </div>
                                </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhuma noticia encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        <p>
            <a class="page-link-ntc" href="?page=1" data-page="1"><<</a>
            <?php 
                $first_page = max( $page - $page_interval, 1);
                $last_page = min($num_page_ntc, $page + $page_interval);
                for($p = $first_page ; $p <= $last_page; $p++){
                    if($p === $page){
                        echo "<a class='page-link-ntc' href='?page={$p}' data-page='{$p}' style='pointer-events: none;' >{$p}</a>";
                    }else{
                        echo "<a class='page-link-ntc' href='?page={$p}' data-page='{$p}'>[{$p}]</a>";
                    }
                    
                }
            ?>
            
            <a class="page-link-ntc" href="?page=<?=$num_page_ntc?>" data-page="<?=$num_page_ntc?>">>></a>
        </p>
        <input type="submit" class="add-noticia" value="Adicionar Noticia"></div>
        <script>

            /*Eventos edição, adição e paginação consulta noticias */
            $(document).ready(function(){
                $(document).on('click', '.editar-noticia', function (e) {
                    e.preventDefault();
               
                let noticiaId = $(this).data('id'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'editar_noticia.php',
                        data: {id: noticiaId},
                        success: function(response){
                            $('#conteudo').html(response);
                        },
                        error: function (){
                            $('#conteudo').html('<p>Erro ao carregar a página de edição.');
                        }
                    });
                });

                $('.add-noticia').click( function(e){
                    e.preventDefault();
                    $('#conteudo').load('assets/admin_add_noticia.php').fail(function () {
                    $("#conteudo").html("<p>Erro ao carregar o conteúdo solicitado.</p>");
                    });
                });

                
            });
            $(document).ready(function(){
                $(document).on('click', '.page-link-ntc:not(li a.items)', function (e) {
                e.preventDefault();
               
                let pageNtcId = $(this).data('page'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'assets/consulta_noticias.php',
                        data: {page: pageNtcId},
                        success: function(response){
                            $('#conteudo-admin').html(response);
                        },
                        error: function (){
                            $('#conteudo-admin').html('<p>Erro ao carregar a página de edição.');
                        }
                    });
                });
            });
        </script>
  </body>
</html>