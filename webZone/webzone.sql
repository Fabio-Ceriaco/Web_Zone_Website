-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09-Jan-2025 às 09:16
-- Versão do servidor: 8.3.0
-- versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `webzone`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apelido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telemovel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `mensagem` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `nome`, `apelido`, `telemovel`, `email`, `user_type`, `data`, `mensagem`) VALUES
(1, 'Fábio', 'Ceriaco', '969847882', 'ceriacofabio@gmail.com', 'admin', '2025-01-09', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(2, 'João', 'Gomes', '969847882', 'exemplo@gmail.com', 'cliente', '2025-01-09', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(3, 'Pedro', 'Castro', '969847882', 'castropedro@sapo.pt', '', '2025-01-09', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_original_imagem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noticia` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `nome_original_imagem`, `imagem_path`, `descricao`, `noticia`, `data`) VALUES
(2, 'Japão acusa hackers de grupo chinês MirrorFace de dezenas de ciberataques', 'transferir.webp', 'image_noticias/677e736a289b3.webp', 'O Japão acusou hoje o grupo chinês de piratas informáticos MirrorFace de mais de 200 ciberataques executados nos últimos cinco anos contra o país, visando agências de segurança nacional e dados de alta tecnologia.', 'A Agência Nacional da Polícia (NPA) do Japão afirmou que a sua análise dos alvos, métodos e infraestruturas dos ciberataques do MirrorFace, entre 2019 e 2024, concluiu que se trataram de ataques sistemáticos ligados à China, com o objetivo de roubar dados sobre a segurança nacional japonesa e tecnologia avançada.\r\n\r\nOs alvos dos ciberataques liderados pelo Governo chinês incluíram os ministérios dos Negócios Estrangeiros e da Defesa do Japão, a agência espacial do país e indivíduos, incluindo políticos, jornalistas, empresas privadas e grupos de reflexão (&#039;think tanks&#039;) relacionados com tecnologia avançada, disse a NPA.\r\n\r\nOs peritos têm manifestado repetidamente a sua preocupação com a vulnerabilidade da cibersegurança do Japão, especialmente à medida que o país aumenta as suas capacidades de Defesa e trabalha mais estreitamente com os Estados Unidos e outros parceiros para reforçar as defesas cibernéticas.\r\n\r\nA MirrorFace enviou mensagens por correio eletrónico com anexos contendo vírus para organizações e indivíduos, visando visualizar dados salvos em computadores, principalmente entre dezembro de 2019 e julho de 2023, geralmente utilizando endereços do Gmail e do Microsoft Outlook de identidades roubadas, descobriu a investigação da NPA.\r\n\r\nOs emails normalmente usavam como assunto palavras-chave como &quot;aliança Japão - EUA&quot;, &quot;Estreito de Taiwan&quot;, &quot;guerra Rússia - Ucrânia&quot; e &quot;Indo-Pacífico livre e aberto&quot; e incluíam um convite para um painel de estudo, referências e uma lista de painelistas, disse a NPA.\r\n\r\nNoutra tática, os piratas informáticos visaram organizações japonesas nas áreas aeroespacial, semicondutores, informação e comunicações, entre fevereiro e outubro de 2023, explorando vulnerabilidades em redes privadas virtuais para obter acesso não autorizado a informação.\r\n\r\nOs alvos incluíram a Agência Aeroespacial e de Exploração do Japão, ou JAXA, que reconheceu em junho ter sofrido uma série de ciberataques desde 2023, embora a informação sensível relacionada com foguetões, satélites e defesa não tenha sido afetada.\r\n\r\nNo ano passado, um ciberataque paralisou as operações de um terminal de contentores num porto da cidade de Nagoya durante três dias.\r\n\r\nMais recentemente, a companhia aérea Japan Airlines foi atingida por um ciberataque no Natal, causando atrasos e cancelamentos em mais de 20 voos domésticos, embora a transportadora tenha conseguido parar o ataque e restaurar os seus sistemas horas mais tarde.', '2025-01-08 12:45:30'),
(1, 'Facebook substitui verificação de factos por sistema semelhante ao do X de Musk', '61bb869df615505a4df26c54_Meta.jpg', 'image_noticias/677e71fcca4e7.jpg', 'Mark Zuckerberg anunciou mudanças radicais nas políticas de moderação das plataformas da Meta, sinalizando uma nova era no Facebook, Instagram e Threads. A substituição do sistema de verificação de factos por um modelo colaborativo, inspirado no Community', 'A Meta encerrará, por enquanto nos Estados Unidos, o programa de verificação de factos em parceria com organizações independentes, que era utilizado desde 2016 para combater desinformação. Em substituição, Zuckerberg aposta num sistema baseado na contribuição dos próprios utilizadores, algo semelhante à abordagem da X, de Elon Musk.\r\n\r\nSegundo o CEO da Meta, a medida é uma resposta às críticas sobre censura excessiva e aos erros causados por sistemas de moderação complexos. “Reduzir erros e simplificar políticas” foi a promessa feita por Zuckerberg num comunicado em vídeo, onde também defendeu que os governos, com destaque para os europeus, e a imprensa tradicional limitam a liberdade de expressão.\r\n\r\nOutra mudança significativa será a reintrodução de conteúdos políticos nos feeds, revertendo uma decisão anterior de os limitar devido a queixas relacionadas com suposto stress que estes conteúdos estavam a criar nos utilizadores. Zuckerberg argumenta que “os tempos mudaram” e que os utilizadores estão a pedir novamente por esse tipo de publicações.\r\n\r\nSegundo Zuckerberg, a Meta vai concentrar os seus esforços em violações consideradas graves, como conteúdos relacionados com terrorismo, exploração infantil e tráfico de drogas. As restantes violações dependerão mais de denúncias dos utilizadores, com os filtros de moderação a aplicarem maior tolerância antes de remover qualquer publicação.\r\n\r\nPara gerir estas alterações, a equipa de confiança e segurança da Meta será transferida da Califórnia para o Texas, para evitar acusações de serem parciais.\r\n\r\nNo comunicado em vídeo, Mark Zuckerberg comparou ainda a política mais permissiva dos EUA, que, segundo o líder da Meta, permite acelerar o desenvolvimento, criticando diretamente as políticas de regulação da União Europeia. Zuckerberg declara mesmo que espera colaborar com Trump para defender a liberdade de expressão e as empresas americanas.', '2025-01-08 10:01:38'),
(3, 'A Inteligência Artificial é responsável?', 'transferir.png', 'image_noticias/677e73bf2e3f3.png', 'Da criação de vídeos com avatares realistas até à verificação da identidade humana no mundo digital, passando pelos algoritmos que eliminam preconceitos no recrutamento, o último episódio de ‘Beyond The Summit’ revela como três startups estão a desenvolve', 'A Inteligência Artificial está a seguir os interesses da humanidade? A questão ganha relevância numa altura em que o mundo empresarial atravessa uma profunda transformação impulsionada pela Inteligência Artificial (IA), com mais de 70% das organizações globais a adotarem esta tecnologia em 2024, segundo um estudo da McKinsey.\r\n\r\nO terceiro e último episódio de “Beyond The Summit” entra nos bastidores de três empresas que estão a redefinir os limites da IA responsável, num momento em que crescem as preocupações com questões de segurança, controlo e privacidade.\r\n\r\nA Synthesia revolucionou a criação de vídeos corporativos ao desenvolver uma plataforma que permite gerar avatares realistas (uma espécie de clone digital dos humanos) capazes de falar centenas de línguas. Hoje, esta startup britânica vale mais de mil milhões de dólares e conta com 55% das empresas da Fortune 100 entre os seus clientes.\r\n\r\nDo outro lado do Atlântico, a Nebula.io está a transformar o recrutamento com uma plataforma baseada em IA que analisa 180 milhões de perfis profissionais, ao mesmo tempo que procura eliminar preconceitos na seleção de talento.\r\n\r\nOutro projeto igualmente ambicioso é o da Tools For Humanity, fundada em 2019 por Sam Altman, CEO da OpenAI, e Alex Blania. Numa era em que, de acordo com a Forbes, os bots já representam quase metade do tráfego global da Internet, a empresa desenvolveu uma tecnologia que combina verificação biométrica e blockchain para distinguir humanos de computadores no mundo digital.\r\n\r\nDesde os novos mecanismos de controlo na produção de conteúdo aos sistemas de proteção de identidade na era digital e às tecnologias emergentes como blockchain e biometria, o último episódio de “Beyond The Summit” traça um retrato de uma indústria que procura harmonizar inovação tecnológica com responsabilidade social.\r\n\r\n“Beyond The Summit” é uma minissérie de três episódios baseada nas conversas que Gabriel Lagoa e Miguel Magalhães conduziram durante a Web Summit, em parceria com o Banco Europeu de Investimento (BEI) e o Fundo Europeu de Investimento (FEI).', '2025-01-08 12:46:55'),
(4, 'EUA: Vendas de bens tecnológicos prometem crescer em 2025, se as “taxas Trump” não atrapalharem', 'transferir (1).webp', 'image_noticias/677e7488b9c32.webp', 'A Associação da Eletrónica de Consumo nos Estados Unidos aproveitou a CES para mostrar as contas ao impacto das taxas que Donald Trump tem anunciado que vai aplicar a vários países e indústrias, quando chegar à Casa Branca. E as contas ao ano promissor qu', 'A indústria de eletrónica de consumo começa o ano a mostrar novidades, na CES em Las Vegas e que melhor palco que este para avançar com as melhores e as piores previsões para 2025. As melhores dizem que as vendas de bens e serviços tecnológicos no país devem crescer 3,2% este ano. As menos boas alertam que os números só se concretizam se as taxas que o futuro presidente do país tem anunciado que vai aplicar a vários países e produtos, não forem para frente.\r\n\r\nAmbas as contas são da responsabilidade da Associação de Eletrónica de Consumo. A previsão de vendas indica que o crescimento de 3,2% vai permitir ao sector faturar 537 mil milhões de dólares este ano. As estimativas são das próprias empresas do sector que vêm sinais sólidas de um crescimento na procura.\r\n\r\nNuma outra pesquisa (How Proposed Trump Tariffs Increase Prices for Consumer Technology Products), que encontrou no palco da CES um bom local para voltar a estar em destaque, apurou-se que as futuras potenciais tarifas aplicadas a produtos tecnológicos podem diminuir em 90 a 143 mil milhões de dólares o poder de compra dos americanos. Só as compras de portáteis e tablets podem ser reduzidas em 68%. Nas consolas o impacto pode ascender a 58% e nos smartphones acredita-se que o impacto no poder de compra rondará os 37%.\r\n\r\n“O sector tecnológico é o motor económico da América, impulsionando a inovação global e a criação de emprego”, sublinha Gary Shapiro, CEO da CTA, citado no comunicado que divulga os números. “A nossa previsão positiva reflete a força da indústria, mas as tarifas propostas ameaçam o poder deflacionário da tecnologia na economia global”.\r\n\r\nO vice-presidente da associação complementa as declarações, acrescentando que retaliar sobre os “parceiros comerciais aumenta os custos, perturba as cadeias de abastecimento e prejudica a competitividade das indústrias americanas”.', '2025-01-08 12:50:16'),
(5, 'HP Omen Max 16: uma “besta” de gaming com inteligência superior', 'transferir (2).webp', 'image_noticias/677e7561f2866.webp', 'A HP anunciou na CES 2025 aquele que é seu portátil de gaming mais poderoso da linha Omen e tecnologia de inteligência artificial que ajuda no desempenho.', 'A CES 2025 tem sido palco dos anúncios de portáteis de gaming das principais fabricantes. Depois da Asus, Acer e Lenovo, junta-se a HP a revelar aquele que diz ser a sua máquina mais poderosa para jogar. Trata-se do HP Omen Max 16, acompanhado da nova tecnologia Omen AI, um computador que foi desenhado para se ajustar automaticamente ao desempenho e temperaturas, para manter a fluidez de performance nos jogos.\r\n\r\nO Omen Max 16 oferece configurações baseadas nos processadores AMD Ryzen AI 9 ou Intel Core Ultra 9 e podem ter até 64 GB de RAM DDr5-5600. Como seria de esperar, o portátil está artilhado com as novas placas gráficas da Nvidia, as GeForce RTX 50. Além do hardware mais recente, acedendo às tecnologias DLSS 4 da Nvidia, a HP introduziu o novo Modo Unleashed, acessível no Gaming Hub da Omen, para que os jogadores possam definir manualmente as opções de energia mediante as suas necessidades.\r\n\r\nO modelo tem um ecrã OLED de 16 polegadas, com resolução de 2560x1600, até 500 nits de brilho e compatibilidade com a palete de cores DCI-P3.\r\n\r\nAlém do gaming, os utilizadores vão poder usar as ferramentas de inteligência artificial e os criativos têm acesso ao Nvidia Studio, assim como aos Microserviços NIM, para criar modelos de assistentes e agentes inteligentes.\r\n\r\nUm dos segredos do HP Omen Max 16 é o novo sistema de refrigeração, com a estreia do material híbrido Cryo Compound, que combina metal líquido e massa metálica para melhorar a dissipação do calor. A arquitetura Omen Tempest Cooling Pro promete ajudar a manter a máquina arrefecida. A tecnologia Fan Cleaner inverte periodicamente a direção de rotação da ventoinha para evitar a acumulação de pó, eliminando a necessidade de limpeza frequente.\r\n\r\nO portátil está disponível com duas opções de cor: branco cerâmico e preto sombra, assente num chassis de metal. O modelo tem uma barra de luz RGB frontal opcional, assim como um teclado RGB por tecla opcional sem treliça que foi inspirado no HyperX.', '2025-01-08 12:53:53'),
(6, 'Em 2025, 1 em cada 4 carros vendidos será elétrico, diz relatório', 'Renault-Scenic-E-Tech-100-eletrico0-1.jpg', 'image_noticias/677e75f7b1183.jpg', 'Este ano começou há poucos dias, mas já há previsões animadoras para a indústria dos carros elétricos. As vendas deverão continuar a crescer, nos Estados Unidos da América (EUA), representando um em cada quatro veículos vendidos, de acordo com um novo rel', 'Depois de encerrar 2024 com bons resultados, a indústria automóvel dos EUA parece estar em tendência crescente, apesar das incertezas. De facto, no seu relatório 2025 Outlook, a Cox Automotive prevê que este será o melhor ano para o mercado automóvel desde antes da pandemia, em 2019.\r\n\r\nCom exceção de Stellantis e da Tesla, quase todas as fabricantes de automóveis registaram vendas mais altas ano a ano em 2024. A General Motors foi a fabricante de automóveis mais vendida, no ano passado, com a Honda e a Mazda a registarem um forte crescimento.\r\n\r\nO mercado dos EUA registou um recorde de vendas de veículos elétricos em 2023 e 2024, e espera-se que esta tendência continue em 2025. A Cox Automotive prevê que os elétricos representarão aproximadamente 10% do total do mercado no próximo ano, contra cerca de 7,5% em 2024.\r\n\r\nPor sua vez, os híbridos e os plug-ins representarão cerca de 15% do mercado, e as vendas de veículos com motor de combustão interna cairão para 75% do volume total, o nível mais baixo de que há registo.\r\n\r\nSegundo a Cox Automotive, &quot;os consumidores estão a sentir-se melhor em relação ao caminho a seguir, uma vez que as eleições nos EUA decorreram sem problemas, as taxas de juro estão abaixo dos seus picos e o mercado de trabalho estabilizou&quot;.\r\n\r\nConforme mencionado pelo Electrek, o crescimento dos carros elétricos será apoiado pela chegada de 15 novos modelos, por consumidores que decidirão comprar antes de a administração de Donald  Trump cortar o crédito fiscal de 7500 dólares e por incentivos estatais que contrariem potenciais cortes federais.\r\n\r\nA rápida expansão da rede de carregamento de carros elétricos estará, também, a contribuir para o crescimento.', '2025-01-08 12:56:23');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamentos`
--

DROP TABLE IF EXISTS `orcamentos`;
CREATE TABLE IF NOT EXISTS `orcamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apelido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telemovel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_pagina` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meses` int NOT NULL,
  `extras` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_estimado` double NOT NULL,
  `data_orcamento` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `orcamentos`
--

INSERT INTO `orcamentos` (`id`, `nome`, `apelido`, `email`, `user_type`, `telemovel`, `tipo_pagina`, `meses`, `extras`, `valor_estimado`, `data_orcamento`) VALUES
(1, 'Fábio', 'Ceriaco', 'ceriacofabio@gmail.com', 'admin', '913577103', 'Criação de WebSite', 1, '[\"Quem somos\"]', 1825, '2025-01-09 09:06:46'),
(2, 'Miguel', 'Santos', 'santosmiguel@gmail.com', '', '912345678', 'Criação de WebSite', 3, '[\"Quem somos\",\"Onde estamos\"]', 6674, '2025-01-09 09:09:33'),
(3, 'João', 'Gomes', 'exemplo@gmail.com', 'cliente', '913577103', 'Loja Online', 4, '[\"Galeria de fotografias\"]', 9199, '2025-01-09 09:11:56');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

DROP TABLE IF EXISTS `projetos`;
CREATE TABLE IF NOT EXISTS `projetos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_original_imagem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dados_projeto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tecnologia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempo_conclusao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `projetos`
--

INSERT INTO `projetos` (`id`, `titulo`, `nome_original_imagem`, `imagem_path`, `dados_projeto`, `tecnologia`, `tempo_conclusao`, `data`) VALUES
(23, 'Portfólio', '6777e340c395b.jpg', 'image_projetos/677ea8c242ef7.jpg', 'Uma página de portfólio, que exibe projetos e dados sobre o profissional, totalmente responsivo.', 'HTML5 e CSS3', '1 semana', '2025-01-03 13:16:48'),
(22, 'Landing page de uma loja de instrumentos músicais', '6777e2b822e64.jpg', 'image_projetos/677ea8d5c4a65.jpg', 'Landing page de uma loja de instrumentos musicais, venda e expedição de instrumentos musicais de sopro.', 'HTML5, CSS3 e JavaScript', '1 semana', '2025-01-03 13:14:32'),
(21, 'Landing page', '6777e20c7dab3.jpg', 'image_projetos/677ea8f9d6b10.jpg', 'Construção de uma landing page de uma banda.', 'HTML5, CSS3 e utilização de biblioteca Bootstarp.', '5 dias', '2025-01-03 13:11:40'),
(20, 'Formulário de Candidatura', '6777d8df28d8e.jpg', 'image_projetos/677ea8e75726a.jpg', 'Formulário para submeter dados para uma candidatura.', 'HTML5 e CSS3', '1 dia', '2025-01-03 12:32:31'),
(24, 'Landig page RadioHead', '6777e3bb8c82e.jpg', 'image_projetos/677ea8a9403b4.jpg', 'Landig page de tributo a banda RadioHead, onde é possível, consultar a história da banda, galeria de fotografias, álbuns e os próximos consertos.', 'HTML5 e CSS3.', '1 semana', '2025-01-03 13:18:51'),
(25, 'Validador de números de telefone.', '6777e44f6c282.jpg', 'image_projetos/677ea88f522a8.jpg', 'Uma página para validar números de telefone, introdução do número que se pretende validar na área input e a validação e realizada através de uma expressão regular em JavaScript', 'HTML5, CSS3 e JavaScript', '1 semana', '2025-01-03 13:21:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apelido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`user_id`, `user_type`, `username`, `nome`, `apelido`, `email`, `telefone`, `password`) VALUES
(1, 'admin', 'FábioCeriaco', 'Fábio', 'Ceriaco', 'ceriacofabio@gmail.com', '913577103', '$2y$10$FS4g6nfchP1njEl6bNSrwu9t5QTiMADaxeUJYMriQ.H.1PZIxN4G6'),
(2, 'cliente', 'JoaoGomes', 'João', 'Gomes', 'exemplo@gmail.com', '9123456789', '$2y$10$itnnfybzWFZdQLLRG2Qg1ewPX1krmOTHEc2d5ODs3XP3aooSoKkBi'),
(3, 'cliente', 'AnaRusso', 'Ana', 'Russo', 'exemplo2@gmail.com', '9123456789', '$2y$10$E1c61mAa0UAEd6IlmsHVFeggFmyRi/DH5CxVl1v1Qi2075ZmRx3Yi'),
(4, 'cliente', 'RuiRibeiro@', 'Rui', 'Ribeiro', 'exemplo3@gmail.com', '9123456789', '$2y$10$LIirDNTfWUdgduE9bpjVkeIil.pf2gdv7tEXcEVhlPEofNzN8QnqW'),
(5, 'cliente', 'Paulinha1975', 'Paula', 'Curva', 'exemplo4@gmail.com', '9123456789', '$2y$10$wnQ3pj9fIF69AhCzwdY9Se5OrZH7GhxHoEkdCH9GwxRZH8Y61M6RK'),
(6, 'cliente', 'LuisFonseca', 'Luis', 'Fonseca', 'exemplo5@gmail.com', '9123456789', '$2y$10$/Pz6dyze8rw17x/QOvie5Oua0MCNUgIwFvTAp/VoFTzAecRApv4QC');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
