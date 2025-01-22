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
    $sql_quantidade = "SELECT count(*) as c FROM mensagens";
    $count_stmt = $pdo->prepare($sql_quantidade);
    $count_stmt -> execute();
    $sql_mensagens_count = $count_stmt->fetch(PDO::FETCH_ASSOC);
    $mensagens_count = $sql_mensagens_count['c'];
    
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1 ;
    $limit = 3;
    $page_interval = 2;
    $offset = ($page - 1) * $limit;

    $num_page = ceil($mensagens_count/$limit);
    // Obter dados do utilizador
    $sql = "SELECT * FROM mensagens ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt ->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt -> bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }
                tbody tr:nth-child(even){
                    background-color: gray;
                }
                tbody tr:hover {
                background-color: gray;
                
                }

                .resp-mensagem, .delete-btn{
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
                .resp-mensagem{
                    background-color: #4caf50;
                }
                .resp-mensagem:hover{
                    background-color: #45a049;
                }
                .delete-btn{
                    background-color: #f44336;
                }
                .delete-btn:hover{
                    background-color: #d32f2f;
                }
                p{
                    text-align: center;
                    margin: 1rem 1rem;
                }
                a.page-link-msg{
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
                a.page-link-msg:hover{
                    background-color: #00a3cc;
                }
                @media (max-width: 768px){
                    thead th, rbody td{
                        font-size: 0.9rem;
                        padding: 8px;
                    }
                    .resp-mensagem, .delete-btn{
                        font-size: 0.8rem;
                    }

                }
                @media (max-width: 480px){
                    table{
                        font-size: 0.8rem;
                        width: 100%;
                    }
                    .resp-mensagem, .delete-btn{
                        font-size: 0.7rem;
                        padding: 5px 10px;
                    }
                }
                
    </style>-->  
  </head>
  <body>
        <div class="titulo"><h2>Consultar Mensagens</h2></div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Função</th>
                    <th>Nome</th>
                    <th>Apelido</th>
                    <th>Telemovél</th>
                    <th>Email</th>
                    <th>Data</th>
                    <th>Mensagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($mensagens): ?>
                    <?php foreach ($mensagens as $mensagem): ?>
                        <tr>
                            
                                <td id="valor_id"><?=$mensagem['id']?></td>
                                <td id="valor_user_type"><?=$mensagem['user_type']?></td>
                                <td id="valor_user_type"><?=$mensagem['nome']?></td>
                                <td id="valor_username"><?=$mensagem['apelido']?></td>
                                <td id="valor_nome"><?=$mensagem['telemovel']?></td>
                                <td id="valor_apelido"><?=$mensagem['email']?></td>
                                <td id="valor_email"><?=$mensagem['data']?></td>
                                <td id="valor_telefone"><?=$mensagem['mensagem']?></td>
                                <td id="acoes">
                                    <a class="resp-mensagem" type="button"  href="responder_mensagem.php?id=<?=$mensagem['id']?>" data-id="<?=$mensagem['id']?>" >Responder</a>
                                    <form action="assets/admin_delete_mensagem.php" method="post">
                                    <button class="delete-btn" id="delete-btn" type="submit" name="delete-mensagem" value="<?=$mensagem['id'];?>" onclick="return confirm('Deseja eliminar esta Mensagem?')">Delete</button>
                                    </form>
                                </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhuma mensagem encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <p>
            <a class="page-link-msg" href="?page=1" data-page="1"><<</a>
            <?php 
                $first_page = max( $page - $page_interval, 1);
                $last_page = min($num_page, $page + $page_interval);
                for($p = $first_page ; $p <= $last_page; $p++){
                    if($p === $page){
                        echo "<a class='page-link-msg' href='?page={$p}' data-page='{$p}' style='pointer-events: none;' >{$p}</a>";
                    }else{
                        echo "<a class='page-link-msg' href='?page={$p}' data-page='{$p}'>[{$p}]</a>";
                    }
                    
                }
            ?>
            
            <a class="page-link-msg" href="?page=<?=$num_page?>" data-page="<?=$num_page?>">>></a>
        </p>
       <script>

            /*Eventos de resposta e paginação consulta Mensagens */
            $(document).ready(function(){
                $(document).on('click', '.resp-mensagem', function (e) {
                e.preventDefault();
               
                let userId = $(this).data('id'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'assets/responder_mensagem.php',
                        data: {id: userId},
                        success: function(response){
                            $('#conteudo').html(response);
                        },
                        error: function (){
                            $('#conteudo').html('<p>Erro ao carregar a página de resposta.');
                        }
                    });
                });

                

                
            });
            $(document).ready(function(){
                $(document).on('click', '.page-link-msg:not(li a.items)', function (e) {
                e.preventDefault();
               
                let pageId = $(this).data('page'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'assets/consulta_mensagens.php',
                        data: {page: pageId},
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