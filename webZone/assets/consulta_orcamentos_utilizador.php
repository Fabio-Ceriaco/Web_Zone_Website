<?php
include '../includes/conexao.php';
if(!isset($_SESSION)){
    session_start();
    
  }




// Verificar se o utilizador tem login e é admin
if (!isset($_SESSION['username']) || !isset($_SESSION['user_type']) || !isset($_SESSION['email'])) {
    echo "<script>alert('Sessão expirada ou não configurada!'); window.location.href = '../index.php';</script>";
    exit();
}
    
    
    $user_email= $_SESSION['email'];


try {
   
    $sql = "SELECT * FROM orcamentos WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    
    $stmt -> bindParam(':email', $user_email, PDO::PARAM_STR);
    $stmt->execute();
    $orcamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Consulta Orçamentos</title> 
   <!-- <style>
                .container{
        
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
          width: auto;
          margin-top: 20px;
          padding: 20px;
          background-color: rgba(255, 255, 255, 0.05);
          border: 1px solid #ddd;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

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
                a.page-link-orc{
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
                a.page-link-orc:hover{
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
                
    </style> --> 
  </head>
  <body>
  <section class="conteudo-admin" id="conteudo-admin">
        <div class="titulo"><h2>Consultar Orçamentos</h2></div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Apelido</th>
                    <th>Email</th>
                    <th>Função</th>
                    <th>Telemovél</th>
                    <th>Tipo de Página</th>
                    <th>Meses</th>
                    <th>Extras</th>
                    <th>Valor Estimado</th>
                    <th>Data de Orçamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orcamentos): ?>
                    <?php foreach ($orcamentos as $orcamento): ?>
                        <tr>
                            
                                <td id="valor_id"><?=$orcamento['id']?></td>
                                <td id="valor_nome"><?=$orcamento['nome']?></td>
                                <td id="valor_apelido"><?=$orcamento['apelido']?></td>
                                <td id="valor_email"><?=$orcamento['email']?></td>
                                <td id="valor_user_type"><?=$orcamento['user_type']?></td>
                                <td id="valor_telemovel"><?=$orcamento['telemovel']?></td>
                                <td id="valor_tipo_pag"><?=$orcamento['tipo_pagina']?></td>
                                <td id="valor_meses"><?=$orcamento['meses']?></td>
                                <td id="valor_extras"><?=$orcamento['extras']?></td>
                                <td id="valor_estimado"><?=$orcamento['valor_estimado']?></td>
                                <td id="valor_data"><?=$orcamento['data_orcamento']?></td>
                                <td id="acoes">
                                    <form action="assets/admin_delete_orcamentos.php" method="post">
                                    <button class="delete-btn" id="delete-btn" type="submit" name="delete-orcamento" value="<?=$orcamento['id'];?>" onclick="return confirm('Deseja eliminar este Orçamento?')">Delete</button>
                                    </form>
                                </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum orçamento encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
  </section>
        <script>

            
            $(document).ready(function(){
                

                $(document).on('click', '.page-link-orc:not(li a.items)', function (e) {
                e.preventDefault();
               
                let pageOrcId = $(this).data('page'); //Obter o valor href

                        $.ajax({
                        method: 'GET',
                        url: 'assets/consulta_orcamentos.php',
                        data: {page: pageOrcId},
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