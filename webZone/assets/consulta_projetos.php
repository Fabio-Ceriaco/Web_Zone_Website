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
    $sql_quantidade = "SELECT count(*) as c FROM projetos";
    $count_stmt = $pdo->prepare($sql_quantidade);
    $count_stmt -> execute();
    $sql_projetos_count = $count_stmt->fetch(PDO::FETCH_ASSOC);
    $projetos_count = $sql_projetos_count['c'];
    
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1 ;
    $limit = 3;
    $page_interval = 2;
    $offset = ($page - 1) * $limit;

    $num_page = ceil($projetos_count/$limit);
    // Obter dados do utilizador
    $sql = "SELECT * FROM projetos ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt ->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt -> bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
  </head>
  <body>
        
        <div class="titulo"><h2>Consultar Projetos</h2></div>
        <div class="tb-projetos">
        <table >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagem</th>
                    <th>Dados do Projeto</th>
                    <th>Tecnologias</th>
                    <th>Tempo Conclusão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($projetos): ?>
                    <?php foreach ($projetos as $projeto): ?>
                        <tr>
                            
                                <td id="valor_id"><?= htmlspecialchars($projeto['id'])?></td>
                                <td id="valor_titulo<?=$projeto['titulo']?>"><?= htmlspecialchars($projeto['titulo'])?></td>
                                <td id="valor_imagem"><img
                                style="margin-right: 20px"
                                class="example-image"
                                src="<?= htmlspecialchars($projeto['imagem_path'])?>"
                                alt="image-1"
                                width="100%"
                                height="100%"/></td>
                                <td id="valor_dados"><?= htmlspecialchars($projeto['dados_projeto'])?></td>
                                <td id="valor_tecnologias"><?= htmlspecialchars($projeto['tecnologia'])?></td>
                                <td id="valor_temp_conclusao"><?= htmlspecialchars($projeto['tempo_conclusao'])?></td>
                                
                                <td id="acoes">
                                    <div>
                                    <a class="editar-projeto" type="button"  href="editar_projetos.php?id=<?=$projeto['id']?>" data-id="<?=$projeto['id']?>" >Editar</a>
                                    <form action="assets/admin_delete_projeto.php" method="post">
                                    <button class="delete-btn" id="delete-btn" type="submit" name="delete-pojeto" value="<?=$projeto['id'];?>" onclick="return confirm('Deseja eliminar este Projeto?')">Delete</button>
                                    </form>
                                    </div>
                                </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum projeto encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        <p>
            <a class="page-link-proj" href="?page=1" data-page="1"><<</a>
            <?php 
                $first_page = max( $page - $page_interval, 1);
                $last_page = min($num_page, $page + $page_interval);
                for($p = $first_page ; $p <= $last_page; $p++){
                    if($p === $page){
                        echo "<a class='page-link-proj' href='?page={$p}' data-page='{$p}' style='pointer-events: none;' >{$p}</a>";
                    }else{
                        echo "<a class='page-link-proj' href='?page={$p}' data-page='{$p}'>[{$p}]</a>";
                    }
                    
                }
            ?>
            
            <a class="page-link-proj" href="?page=<?=$num_page?>" data-page="<?=$num_page?>">>></a>
        </p>
        <input type="submit" class="add-projeto" value="Adicionar Projeto"></div>
        <script>

            /*Eventos para edição, adição e paginação projetos */
            $(document).ready(function(){
                $(document).on('click', '.editar-projeto', function (e) {
                    e.preventDefault();
               
                let projetoId = $(this).data('id'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'editar_projetos.php',
                        data: {id: projetoId},
                        success: function(response){
                            $('#conteudo').html(response);
                        },
                        error: function (){
                            $('#conteudo').html('<p>Erro ao carregar a página de edição.');
                        }
                    });
                });

                $('.add-projeto').click( function(e){
                    e.preventDefault();
                    $('#conteudo').load('assets/admin_add_projetos.php').fail(function () {
                    $("#conteudo").html("<p>Erro ao carregar o conteúdo solicitado.</p>");
                    });
                });
                
            });
            $(document).ready(function(){
                $(document).on('click', '.page-link-proj:not(li a.items)', function (e) {
                e.preventDefault();
               
                let pageId = $(this).data('page'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'assets/consulta_projetos.php',
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