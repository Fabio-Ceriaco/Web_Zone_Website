<?php
require './includes/conexao.php';
if(!isset($_SESSION)){
  session_start();
  
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
  </head>
  
  <body>
      <form id="orcamentos" oninput="calcularOrcamento()" action="sub_orcamento.php" method="post">
              <!-- Dados -->
              <div id="form-dados">
                <h2>Dados</h2>
                <label for="nome_orcamentos">Nome: </label>
                <input type="text" name="nome_orcamentos" id="nome_orcamentos" onchange="validarNome(this.value)" required />
                <span class="erro" id="nomeErro"></span>

                <label for="apelido_orcamentos">Apelido: </label>
                <input type="text" name="apelido_orcamentos" id="apelido_orcamentos" onchange="validarApelido(this.value)" required />
                <span class="erro" id="apelidoErro"></span>
                <label for="email_orcamentos">Email: </label>
                <input type="email" name="email_orcamentos" id="email_orcamentos" onchange="validarEmail(this.value)" required />
                <span class="erro" id="emailErro"></span>

                <label for="telemovel_orcamentos">Telemóvel: </label>
                <input type="text" name="telemovel_orcamentos" id="telemovel_orcamentos" onchange="validarTelemovel(this.value)" required />
                <span class="erro" id="telemovelErro"></span>
              </div>

              <!-- Pedido de Orçamento -->
              <div id="form-pedido">
                <h3>Pedido de Orçamento</h3>
                <label for="opcao">Tipo de página web:</label>
                <select name="opcao" id="opcao" required>
                  <option value="0">Selecione uma opção</option>
                  <option value="Criação de WebSite" data-preco="1500">Criação de WebSite</option>
                  <option value="Loja Online" data-preco="2000">Loja Online</option>
                  <option value="WebSite + Catálogo" data-preco="3000">WebSite + Catálogo</option>
                  <option value="SEO - Otimização Web" data-preco="500">SEO - Otimização Web</option>
                  <option value="E-mail Marketing" data-preco="1000">E-mail Marketing</option>
                </select>
                <span class="erro" id="opcaoErro"></span><br />

                <label for="meses">Prazo em meses: </label>
                <input type="number" name="meses" id="meses" required />
                <span class="erro" id="mesesErro"></span><br />
              </div>

              <!-- Extras -->
              <div id="extras">
                <h3>Marque os separadores desejados</h3>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="quemsomos" value="Quem somos" />
                  <label for="quemsomos">Quem somos</label>
                </div>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="ondestamos" value="Onde estamos" />
                  <label for="ondestamos">Onde estamos</label>
                </div>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="galeria" value="Galeria de fotografias" />
                  <label for="galeria">Galeria de fotografias</label>
                </div>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="noticias" value="eCommerce" />
                  <label for="extras[ecommerce]">eCommerce</label>
                </div>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="gestao" value="Gestão interna" />
                  <label for="gestao">Gestão interna</label>
                </div>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="noticias" value="Notícias" />
                  <label for="noticias">Notícias</label>
                </div>
                <div class="extra">
                  <input type="checkbox" name="extras[]" id="social" value="Redes sociais" />
                  <label for="social">Redes sociais</label>
                </div>
              </div>

              <!-- Orçamento Estimado -->
              <div class="total">
                <h3>Orçamento Estimado</h3>
                <p>(É um valor meramente indicativo, pode sofrer alterações)</p>

                <input type="text" name="total" id="total" readonly value="" />
              </div>

              <button type="submit" id="orcamento-btn">Enviar</button>
      </form>
     <!-- <script>

        /*Validações secção orçamentos */
        //validar campo nome
        const nome =document.getElementById('nome_orcamentos');
        const apelido =document.getElementById('apelido_orcamentos');
        const telemovel =document.getElementById('telemovel_orcamentos');
        const emial =document.getElementById('email-orcamentos');
        const regex_nome = /^[a-zA-Z\s-]+$/;
        const regex_telemovel = /^(\+?351)?9\d\d{7}$/;
        const regex_email = /^((?!\.)[\w-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/gim;

        function validarNome(nome){
          if(nome.length == 0 || !regex_nome.test(nome)){
            nomeErro.textContent = 'Por favor introduza um Nome válido.';
          }
        }
        function validarApelido(apelido){
          if(apelido.length == 0 || !regex_nome.test(apelido)){
            apelidoErro.textContent = 'Por favor introduza um Apelido válido.';
          }
        }
        function validarEmail(email){
          if(email.length == 0 || !regex_email.test(email)){
            emailErro.textContent = 'Por favor introduza um E-mail válido.'
          }
        }
        function validarTelemovel(telemovel){
          if(telemovel.length == 0 || !regex_telemovel.test(telemovel)){
            telemovelErro.textContent = 'Por favor introduza um número de Telemóvel válido.';
          }
        }

        //Calculo do fromulário de orçamentos

            function validarOpcao(opcao) {
              const opcaoErro = document.getElementById("opcaoErro");
              if (opcao === "") {
                opcaoErro.textContent = "Por favor, selecione uma opção.";
                return false;
              }
              opcaoErro.textContent = "";
              return true;
            }

            function validarMeses(meses) {
              const mesesErro = document.getElementById("mesesErro");
              if (isNaN(meses) || meses <= 0) {
                mesesErro.textContent = "Insira um número de meses válido.";
                return false;
              }
              mesesErro.textContent = "";
              return true;
            }
            function calcularOrcamento() {
              const opcaoSelect = document.getElementById("opcao");
              const opcao = opcaoSelect.value;
              const precoUnitario =
                parseFloat(
                  opcaoSelect.options[opcaoSelect.selectedIndex].getAttribute("data-preco")
                ) || 0;
              const meses = parseInt(document.getElementById("meses").value) || 0;

              const extrasCheckboxes = document.querySelectorAll(
                'input[name="extras[]"]:checked'
              );
              let totalExtras = 0;
              const extrasSelecionados = [];
              extrasCheckboxes.forEach((checkbox) => {
                totalExtras += parseFloat("421.05");
                extrasSelecionados.push({
                  nome: checkbox.nextElementSibling.textContent,
                  valor: parseFloat('421.05'),
                });
              });

              if ( !validarOpcao(opcao) || !validarMeses(meses)) {
                atualizarTotal("0,00€");
                return;
              }

              const totalSemDesconto = (precoUnitario + totalExtras) * meses;

              let descontoPercentual = 0;
              if (meses >= 1 && meses <= 6) descontoPercentual = 5;
              else if (meses >= 7 && meses <= 12) descontoPercentual = 10;
              else if (meses >= 13 && meses <= 18) descontoPercentual = 15;
              else if (meses >= 19) descontoPercentual = 20;

              const valorDesconto = (totalSemDesconto * descontoPercentual) / 100;
              const totalComDesconto = totalSemDesconto - valorDesconto;

              const totalComDescontoFormatted = totalComDesconto
                .toFixed(2)
                .replace(".", ",");
              atualizarTotal(totalComDescontoFormatted);

              const extrasList = document.getElementById("extrasList");
              extrasList.innerHTML = extrasSelecionados
                .map(
                  (extra) =>
                    `<li>${extra.nome}: ${extra.valor.toFixed(2).replace(".", ",")}€</li>`
                )
                .join("");
            }

            function atualizarTotal(valor) {
              document.getElementById("total").value = `${valor}€`;
            }
      </script>-->
  </body>
</html>
