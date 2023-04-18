<?php
include_once 'template.php';
require_once 'classes/application_config.php';
require_once 'classes/dao/NoticiaDAO.php';

$noticia = NoticiaDAO::getInstancia()->obterNoticiaPorId($_GET['id']);

?>

<div id="common-home" class="container">
	<ul class="breadcrumb">
		<li>
			<a href="">
				<i class="fa fa-home"></i>
			</a>
		</li>
		<li>
			<a href="noticias">Notícias</a>
		</li>		
	</ul>
  	<p></p>
  	<div class="row">
		<div id="content" class="col-sm-12">
		
			<div>
				<main id="main" class="site-main">
					<article>
						<div>
							<div>		
								<div>
									<img width="1000" height="525" src="<?php echo $noticia->getFoto(); ?> " class="img-responsive">		
								</div>
							</div>
							<div><?php echo $noticia->getData(); ?> </div>
							<header>
								<h1 style="text-align: center;"><?php echo $noticia->getTitulo(); ?></h1>		
							</header>
							<br/>
							<div class="entry-content" itemprop="text">
								<?php echo $noticia->getConteudo(); ?>
							</div>
<!-- EXEMPLO DE COMO DEVE SER GRAVADO:
							<header>
								<h1>Projeto de lei encaminhado à Câmara corrige distorção de nove anos no salário dos agentes políticos de Atibaia</h1>		
							</header>
							<div class="entry-content">
								<h4 style="text-align: center;">Somados os últimos nove anos, perda foi de mais de 56% – índice inflacionário de todo o período</h4>
								<p>Projeto de lei encaminhado pelo Executivo à Câmara Municipal na última semana tem como objetivo corrigir a remuneração do prefeito, vice-prefeito e secretários municipais com base nos índices inflacionários registrados nos últimos nove anos e que deixaram de ser aplicados pela Administração Municipal. A recomposição inflacionária foi adicionada ao salário dos servidores municipais, anualmente, conforme previsto em lei, mas o salário do prefeito, vice-prefeito e secretários municipais ficou congelado. Somados os nove anos, a perda foi de mais de 56% – índice inflacionário de todo o período.</p>
								<p>A reposição inflacionária é uma imposição fixada pela Constituição Federal, em seu artigo 37, que prevê sua aplicação automática de forma a corrigir as perdas decorrentes da variação da inflação durante o período de um ano. Dessa forma, ela costuma ser aplicada automaticamente no âmbito da Administração Municipal como direito legítimo dos servidores. Entretanto, deixou de ser aplicada ao salário dos agentes políticos desde abril de 2014.</p>
								<p>“Tramitam no Superior Tribunal Federal (STF) diversas ações sobre esse tema, apontando como omissão a não revisão das remunerações dos servidores de forma geral, anual, na mesma data e sem distinção de índices. Exemplo disso é que, em uma dessas ações, o ministro Marco Aurélio de Mello pronunciou seu voto condenando o Estado de São Paulo a indenizar os autores em razão do descompasso entre reajustes implementados e a inflação dos períodos. Segundo o ministro, a correção monetária não é ganho, nem lucro, nem vantagem. É apenas uma forma de resguardar os vencimentos dos efeitos da inflação”, explica o secretário de Recursos Humanos, Carlos Américo da Rocha.</p>
								<p>Na justificativa do projeto, o Executivo afirma que “o congelamento dos subsídios dos agentes políticos, desde 2014, prejudicou a contratação de profissionais para contribuir com a prestação de serviços públicos que a população de Atibaia merece e precisa”. “Temos tido dificuldade na reformulação da equipe de governo, especialmente nos cargos que hoje estão ocupados por secretários que já gerenciam outras pastas. Os profissionais não têm se interessado em razão do salário, muito abaixo do que é praticado atualmente no mercado e, inclusive, de cidades vizinhas”, explica o secretário de Governo, André Agatte.</p>
								<p>Como o subsídio do prefeito também é utilizado como “teto” para os salários praticados no âmbito da Administração Municipal – o que está previsto no inciso XI do artigo 37 da Constituição Federal – o congelamento também afetou outros servidores que tiveram sua remuneração reduzida em razão do teto. Ou seja, como nenhum servidor pode ganhar mais que o subsídio do prefeito, que foi congelado em 2014, alguns servidores tiveram sua remuneração reduzida. “Seguindo este raciocínio, podemos concluir que o congelamento dos subsídios dos agentes políticos afeta todos os servidores, visto que suas remunerações estão limitadas ao subsídio de 2014 do prefeito”, diz texto da justificativa do Projeto de Lei.</p>
								<p>“Além da evasão desses servidores, que procuram melhores condições salariais fora da Prefeitura, o congelamento também tem impedido que servidores de carreira ocupem o cargo de secretário. Muitos recebem mais que os secretários e, pelo nível de responsabilidade que o cargo exige, não aceitam o convite em razão do salário”, explica o secretário de Governo, André Agatte.</p>
								<p>A recomposição inflacionária proposta pelo Executivo no projeto de lei teve como base a inflação apurada no período entre 1º de maio de 2014 a 31 de outubro de 2022, já que o último repasse aconteceu em abril de 2014.</p>
								<p>“O mais importante a ressaltar é que essa reposição inflacionária não representa aumento de salário. Ela apenas resgata o valor real dos salários, que foi subtraído pela alta da inflação. É um direito à revisão geral anual de vencimentos baseada nas perdas inflacionárias acumuladas nos doze meses que antecedem a data-base da categoria e que não foi aplicado à remuneração dos agentes políticos desde 2014”, completa o secretário de Recursos Humanos.</p>
								<p></p>
							</div>
-->
						</div>
					</article>
				</main>
			</div>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class='col-sm-1'>
			<button type="button" class="btn btn-success" onclick="javascript:history.back();">Voltar</button>
		</div>
	</div>
	<br>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>