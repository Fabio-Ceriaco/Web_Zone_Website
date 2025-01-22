/*Programação do toggler da NavBar*/
document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.querySelector(".hamburger");
  const navLinks = document.querySelector(".nav-links");
  const links = document.querySelectorAll(".nav-links li");

  function openToggler() {
    //Links animados
    navLinks.classList.toggle("open");
    links.forEach((link) => {
      link.classList.toggle("fade");
    });

    //Hamburger animado
    hamburger.classList.toggle("toggle");
  }

  hamburger.onclick = openToggler;
});

/*Carregamento das páginas */

$(document).ready(function () {
  //carregar conteúdo inicial
  $("#conteudo").load("paginas_principais/sobre.php");

  //Evento para links de navegação geral
  $("#navBar li a.nav-item")
    .not("#link-registo")
    .not("#noticias-link")
    .click(function (e) {
      e.preventDefault();
      $("#navBar li a").removeClass("active"); //Remover a classe 'active' de todos
      $(this).addClass("active"); //adicionar a classe 'active' no item clicado

      let page = $(this).attr("href"); //Obter o valor href
      $("#conteudo").load(page + ".php", function (response, status, xhr) {
        if (status == "error") {
          console.log("Erro ao carregar o conteúdo solicitado.");
        } else {
          console.log("Pagina carregada com sucesso!");
        }
      });
    });

  //Evento específico para link-registo
  $("#link-registo").click(function (e) {
    e.preventDefault();
    $("#conteudo")
      .load("assets/registo.php")
      .fail(function () {
        $("#conteudo").html("<p>Erro ao carregar registo.php.</p>");
      });
  });
});

/*Caixa login */
document.addEventListener("DOMContentLoaded", function () {
  const loginBtn = document.getElementById("login");
  const closeLogin = document.getElementById("closeLogin");
  const registoLink = document.getElementById("link-registo");
  const loginBox = document.getElementById("login-box");

  if (loginBtn && closeLogin && registoLink && loginBox) {
    function showLoginBox() {
      loginBox.style.display = "block";
    }

    function hideLoginBox() {
      loginBox.style.display = "none";
    }

    loginBtn.onclick = showLoginBox;
    closeLogin.onclick = hideLoginBox;
    registoLink.onclick = hideLoginBox;
  } else {
    console.error("Alguns dos elementos não foram encontrados no DOM.");
  }
});

/*-----------------------------------------------------------------------------------------------*/
/*Evento click 'Ler mais */
$(document).ready(function () {
  $(document).on("click", ".noticia-link", function (e) {
    e.preventDefault();

    let noticiaId = $(this).data("id"); //Obter o valor href

    $.ajax({
      method: "GET",
      url: "paginas_principais/noticias.php",
      data: { id: noticiaId },
      success: function (response) {
        $("#conteudo").html(response);
      },
      error: function () {
        $("#conteudo").html("<p>Erro ao carregar a página de edição.");
      },
    });
  });
  /*Botão logout */
  $(document).ready(function () {
    $("#logout").click(function (e) {
      e.preventDefault();
      location.href = "logout.php";
    });
  });
});

/*Logout ao sair do navegador */
//marca que a página não está a ser recarregada
if (!sessionStorage.getItem("reloading")) {
  sessionStorage.setItem("reloading", "false");
}

//antes de sair
window.addEventListener("beforeunload", function () {
  //so executa logout quando fecha a janela
  if (sessionStorage.getItem("reloading") === "false") {
    sessionStorage.setItem("reloading", "true");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "logout.php", true);
    xhr.send();
  }
});

//quando a página for carregada remove a 'reloading'
window.addEventListener("load", function () {
  //se não estava em modo de recarregamento, significa que a página acabou de carregar
  if (sessionStorage.getItem("reloading") === "false") {
    sessionStorage.removeItem("reloading");
  }
});

/*Cerragamento Mapa com Google Maps API */

function initMap() {
  const lat = 38.57088922431315;
  const lng = -7.909359472616847;

  const mapa = new google.maps.Map(document.getElementById("mapa"), {
    zoom: 12,
    center: { lat: lat, lng: lng },
  });
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert("Geolocation não é suportada pelo navegador");
  }
}
function showPosition(position) {
  let latitude = position.coords.latitude;
  let longitude = position.coords.longitude;

  carregarMapa(latitude, longitude);
}

// Iniciar mapa

function carregarMapa(lat, lng) {
  let servicoRota = new google.maps.DirectionsService();
  let mostrarDireccao = new google.maps.DirectionsRenderer();
  let mapa = new google.maps.Map(document.getElementById("mapa"), {
    zoom: 7,
    center: { lat: lat, lng: lng },
  });
  mostrarDireccao.setMap(mapa);

  let moradaEmpresa = new google.maps.LatLng(
    38.57088922431315,
    -7.909359472616847
  );

  calcularRota(servicoRota, mostrarDireccao, lat, lng, moradaEmpresa);
}

//Calcular e mostrar rota, desde a localização do cliente até morada de empresa

function calcularRota(servicoRota, mostrarDireccao, lat, lng, moradaEmpresa) {
  servicoRota.route(
    {
      origin: { lat: lat, lng: lng },
      destination: moradaEmpresa,
      travelMode: "DRIVING",
    },
    function (response, status) {
      if (status == "OK") {
        mostrarDireccao.setDirections(response);
      } else {
        alert("Falha a calcular a rota: " + status);
      }
    }
  );
}

window.onload = function () {
  getLocation();
};

/*Validações secção orçamentos */
//validar campo nome
const nome = document.getElementById("nome_orcamentos");
const apelido = document.getElementById("apelido_orcamentos");
const telemovel = document.getElementById("telemovel_orcamentos");
const emial = document.getElementById("email-orcamentos");
const regex_nome = /[a-zA-Z\u00C0-\u00FF ]+/;
const regex_telemovel = /^(\+?351)?9\d\d{7}$/;
const regex_email = /^((?!\.)[\w-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/gim;

function validarNome(nome) {
  if (nome.length == 0 || !regex_nome.test(nome)) {
    nomeErro.textContent = "Por favor introduza um Nome válido.";
  }
}
function validarApelido(apelido) {
  if (apelido.length == 0 || !regex_nome.test(apelido)) {
    apelidoErro.textContent = "Por favor introduza um Apelido válido.";
  }
}
function validarEmail(email) {
  if (email.length == 0 || !regex_email.test(email)) {
    emailErro.textContent = "Por favor introduza um E-mail válido.";
  }
}
function validarTelemovel(telemovel) {
  if (telemovel.length == 0 || !regex_telemovel.test(telemovel)) {
    telemovelErro.textContent =
      "Por favor introduza um número de Telemóvel válido.";
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
      valor: parseFloat("421.05"),
    });
  });

  if (!validarOpcao(opcao) || !validarMeses(meses)) {
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
