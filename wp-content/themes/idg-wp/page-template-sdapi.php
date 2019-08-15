<?php /* Template Name: SDAPI */ ?>

<?php get_header(); ?>

<script type='text/javascript'>
    jQuery(function () {
        jQuery('.page-template').addClass('home');
    });
</script>

<main id="page-sdapi" class="site-main">

	<section class="carousel-wrapper">
		<?php
		if (idg_wp_get_option('_main_carousel_custom')) {
			if (is_active_sidebar(idg_wp_get_option('_home_widgets_carousel_sidebar'))) :
				dynamic_sidebar(idg_wp_get_option('_home_widgets_carousel_sidebar'));
			endif;
		} else {
			get_template_part('template-parts/jumbotron-carousel');
		} ?>
	</section>

	<section id="news" class="pb-5 pt-5">
		<div class="container">
			<div class="row">
				<div class="overflow-wrapper">

					<?php
					$args = array(
						'posts_per_page' => 1,
						'category_name'  => 'destaquinho-1'
					);
					$news_query = new WP_Query( $args ); ?>

					<?php if ( $news_query->have_posts() ) : ?>

						<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>


							<div class="col-lg-4 mb-5">
								<?php
								if ( has_post_thumbnail() ) {
									$post_thumb = get_the_post_thumbnail_url(get_the_ID(), 'highlight-box');
								} else {
									$post_thumb = get_template_directory_uri() . '/assets/img/fake-img.jpg';
								}
								?>
								<div class="highlight-box" style="background-image: url('<?php echo $post_thumb; ?>')">
									<div class="box-body">
										<?php if( $post_subtitle = get_post_meta( $post->ID, '_post_subtitle', true ) ): ?>
											<span class="cat"><?php echo $post_subtitle?></span>
										<?php endif; ?>
										<h3 class="box-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
									</div>
								</div>
							</div>
						<?php endwhile; ?>

						<?php wp_reset_postdata(); ?>

					<?php endif; ?>

					<?php
					$args = array(
						'posts_per_page' => 1,
						'category_name'  => 'destaquinho-2'
					);
					$news_query = new WP_Query( $args ); ?>

					<?php if ( $news_query->have_posts() ) : ?>

						<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
							<div class="col-lg-4 mb-5">
								<?php
								if ( has_post_thumbnail() ) {
									$post_thumb = get_the_post_thumbnail_url(get_the_ID(), 'highlight-box');
								} else {
									$post_thumb = get_template_directory_uri() . '/assets/img/fake-img.jpg';
								}
								?>
								<div class="highlight-box" style="background-image: url('<?php echo $post_thumb; ?>')">
									<div class="box-body">
										<?php if( $post_subtitle = get_post_meta( $post->ID, '_post_subtitle', true ) ): ?>
											<span class="cat"><?php echo $post_subtitle?></span>
										<?php endif; ?>
										<h3 class="box-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
									</div>
								</div>
							</div>
						<?php endwhile; ?>

						<?php wp_reset_postdata(); ?>

					<?php endif; ?>

					<?php
					$args = array(
						'posts_per_page' => 1,
						'category_name'  => 'destaquinho-3'
					);
					$news_query = new WP_Query( $args ); ?>

					<?php if ( $news_query->have_posts() ) : ?>

						<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
							<div class="col-lg-4 mb-5">
								<?php
								if ( has_post_thumbnail() ) {
									$post_thumb = get_the_post_thumbnail_url(get_the_ID(), 'highlight-box');
								} else {
									$post_thumb = get_template_directory_uri() . '/assets/img/fake-img.jpg';
								}
								?>
								<div class="highlight-box" style="background-image: url('<?php echo $post_thumb; ?>')">
									<div class="box-body">
										<?php if( $post_subtitle = get_post_meta( $post->ID, '_post_subtitle', true ) ): ?>
											<span class="cat"><?php echo $post_subtitle?></span>
										<?php endif; ?>
										<h3 class="box-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
									</div>
								</div>
							</div>
						<?php endwhile; ?>

						<?php wp_reset_postdata(); ?>

					<?php endif; ?>
				</div>

				<div class="col-lg-12 text-center">
					<a href="<?php echo home_url( '/category/noticias/' ); ?>" class="btn text-uppercase mt-1">Mais
						notícias</a>
				</div>
			</div>
		</div>
	</section>

	<?php if ( !idg_wp_get_option('_home_widgets_sections_disable') ):  ?>

		<?php
		$idg_wp_widgets_areas = get_theme_mod( 'idg_wp_widgets_areas' );
		$sections = idg_wp_get_option('_home_widgets_sections');
		$sections = explode( ',', $sections );

		foreach ($sections as $section) : ?>
			<section id="<?php echo $section; ?>" class="<?php echo empty( $idg_wp_widgets_areas['areas'][$section]['section_class'] ) ? 'mt-5 mb-5 pt-4' : $idg_wp_widgets_areas['areas'][$section]['section_class']; ?>">
				<div class="container">
					<div class="row">

						<?php if( $idg_wp_widgets_areas['areas'][$section]['section_title'] ): ?>
							<div class="col-lg-12">
								<h2 class="section-title mb-5 text-center"><?php echo $idg_wp_widgets_areas['areas'][$section]['section_title']; ?></h2>
							</div>
						<?php endif; ?>

						<div class="overflow-wrapper">
							<?php
							if ( is_active_sidebar( $section ) ) :
								dynamic_sidebar( $section );
							endif;
							?>
						</div>
					</div>
				</div>
			</section>
		<?php endforeach; ?>

	<?php endif; ?>

	<section id="multimidia" class="mt-5">
		<div class="container">
			<div class="row">
				<?php get_template_part('template-parts/multimedia-block'); ?>

				<a href="<?php echo get_bloginfo('url'); ?>/multimedia" class="btn btn-ver-mais">Mais Vídeos</a>
			</div>
		</div>
	</section>

		<!--
		<section class="image-and-text" id="salic">
			<div class="container image-right no-border align-center">
				<div class="col-image text-center">
					<div class="box">
						<div style="">
							<h3>O Secretário</h3>
							<img
								src="http://cultura.gov.br/wp-content/uploads/2019/03/Maur%C3%ADcio-Braga-2-768x512.jpg"
								class="">
							<p class="text-justify"><strong>Maurício Braga</strong></br>O advogado paulistano Maurício
								Braga
								é Especialista em Direito Autoral, Propriedade Industrial e Intelectual, com formação na
								Universidade de São Paulo (USP). Braga ainda foi precursor na atuação em combate à
								pirataria
								no Brasil, tendo colaborado com os trabalhos da CPI da Pirataria, criada pela Câmara dos
								Deputados do Congresso Nacional. Conta com mais de 40 anos de experiência no setor,
								atuando
								como advogado ou consultor jurídico.</p>
							<div class="buttons">
								<a href="http://salic.cultura.gov.br/autenticacao/index/index" target="_blank"
								   class="btn btn-acesse">Contatos da SDAPI</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-text">
					<h2 class="section-title mb-4">SDAPI</h2>
					<h4 class="section-title mb-4">Secretaria de Direitos Autorais e Propriedade Intelectual</h4>
					<p class="text-justify">A Secretaria de Direitos Autorais e Propriedade Intelectual (SDAPI) atua
						como
						órgão regulador e fiscalizador, estabelecendo as bases para que a política de proteção dos
						direitos
						autorais seja aprimorada e avance para outros campos da cultura, como o audiovisual, o teatro e
						as
						plataformas de conteúdo digital. A secretaria conta com uma coordenação específica para o
						desenvolvimento de políticas e ações articuladas de combate à pirataria e ao tráfico de bens
						culturais.</p>

				</div>
			</div>
		</section>

		<section class="image-and-text bg-grey-2" id="salic-mobile">

			<div class="container image-left no-border align-center">
				<div class="col-image text-center">
					<div class="box">
						<img src="http://cultura.gov.br/wp-content/uploads/2019/07/Dia-do-Advogado-287x300.jpg"
							 class="">
					</div>
				</div>

				<div class="col-text">
					<h2 class="section-title mb-4">Consultas Públicas, Chamadas Para Manifestações e Notícias
						Regulatórias</h2>
					<ul>
						<li><a href="http://cultura.gov.br/leidedireitosautorais/" target="_blank"
							   rel="noopener noreferrer">Formulário de Consultas e Sugestões para a Reforma da Lei de
								Direitos Autorais</a></li>
						<li>E-mail para recebimento: <strong><a href="mailto:consulta.lda@cultura.gov.br">consulta.lda@cultura.gov.br</a></strong>
						</li>
						<li>Data de encerramento da consulta: <strong>15/09/2019</strong></li>
						<li>Em caso de dúvidas, envie um e-mail para <a href="mailto:direito.autoral@cultura.gov.br">direito.autoral@cultura.gov.br</a>
						</li>
					</ul>
					<div>
						<p>– Lei n° 9.610/1998: <a href="http://www.planalto.gov.br/ccivil_03/leis/l9610.htm">http://www.planalto.gov.br/ccivil_03/leis/l9610.htm</a>
						</p>
						<p>– Tratado da OMPI sobre Direito de Autor (WCT): <a
								href="https://wipolex.wipo.int/en/treaties/textdetails/12740">https://wipolex.wipo.int/en/treaties/textdetails/12740</a>
						</p>
						<p>– Tratado da OMPI sobre Prestações e Fonogramas (WPPT): <a
								href="https://wipolex.wipo.int/en/treaties/textdetails/12743">https://wipolex.wipo.int/en/treaties/textdetails/12743</a>
						</p>
						<p>– Tratado de Pequim sobre Intepretações e Execuções Audiovisuais: <a
								href="https://wipolex.wipo.int/en/treaties/textdetails/12213">https://wipolex.wipo.int/en/treaties/textdetails/12213</a>
						</p>
					</div>
				</div>
			</div>
		</section>

		<section class="image-and-text" id="versalic">

			<div class="container image-right no-border align-center">
				<div class="col-image text-center">
					<div class="box">
						<img src="http://cultura.gov.br/wp-content/uploads/2019/08/cartilha.png" class="">
					</div>
				</div>

				<div class="col-text">
					<h2 class="section-title mb-4">Legislação & Normas</h2>
					<ul>
						<li>
							<a href="http://cultura.gov.br/wp-content/uploads/2019/02/Cad-Cons-7ª-Edição-13-12-2018-LG-Interna-e-Externa-NOVAS-ATUALIZAÇÕES_DECRETO-E-MARRAQUECHE.pdf"
							   target="_blank" rel="noreferrer noopener"
							   aria-label="Caderno de normas&nbsp;(.pdf) Lei 9.610/1998&nbsp;(versão em inglês) Lei 9.610/1998&nbsp;(versão em espanhol) (opens in a new tab)">Caderno
								de normas</a>&nbsp;(.pdf)
						</li>
						<li><a rel="noreferrer noopener"
							   href="http://antigo.cultura.gov.br/documents/10883/1527715/lei+9160+-+ingl%C3%AAs.pdf/288bfd8e-322a-4700-8096-028f6614085b"
							   target="_blank">Lei 9.610/1998</a>&nbsp;(versão em inglês)
						</li>
						<li><a rel="noreferrer noopener"
							   href="http://antigo.cultura.gov.br/documents/10883/1527715/lei+9610+-+espanhol.pdf/470dc6b1-077a-4a26-be2a-4b36091d626d"
							   target="_blank">Lei 9.610/1998</a>&nbsp;(versão em espanhol)
						</li>
					</ul>

					<div class="buttons">
						<a rel="noreferrer noopener"
						   href="http://antigo.cultura.gov.br/documents/10883/1527715/cartilha_2510_traficoilicito.pdf/7939b8b8-3119-4787-aa0e-9b999e6b2a63"
						   class="btn btn-acesse" target="_blank">Cartilha de Tráfico de Bens Culturais</a>
					</div>
				</div>
			</div>
		</section>

		<section class="image-and-text bg-grey-2" id="comparar">

			<div class="container image-left no-border align-center">
				<div class="col-image text-center">
					<div class="box">
						<img src="http://cultura.gov.br/wp-content/uploads/2019/08/contato.jpeg" class="">
					</div>
				</div>

				<div class="col-text">
					<h2 class="section-title mb-4">Contatos</h2>
					<p><a rel="noreferrer noopener" href="mailto:direito.autoral@cultura.gov.br" target="_blank">direito.autoral@cultura.gov.br</a><br>(61)
						2024-2287<br>Ministério da Cidadania<br>Esplanada dos Ministérios, Bloco B, 4º andar<br>CEP
						70.068-900, Brasília-DF</p>

					<div class="buttons">
						<a href="http://www.mds.gov.br/ministerio-da-cidadania/ouvidoria-do-ministerio" target="_blank"
						   class="btn btn-acesse">Acesse</a>
					</div>
				</div>
			</div>
		</section>

		<section id="multimidia" class="mt-5">
			<div class="container">
				<div class="row">
					<div class="highlight video"
						 style="background-image: url('http://leideincentivoacultura.cultura.gov.br/wp-content/uploads/2019/03/carrossel-2-1080x500.jpg');">
						<a href="http://leideincentivoacultura.cultura.gov.br/multimedia/nova-marca-rouanet/">
							<div class="align">
								<div class="text">
									<h3>A Lei de Incentivo à Cultura está de cara nova. Conheça!</h3>
									<span>Saiba mais sobre a nova marca da Lei de Incentivo à Cultura. Com as mudanças nas regras, a Lei ficou mais inclusiva, democrática e cidadã</span>
									<span><u>Ver Mais</u></span>
								</div>
							</div>
						</a>
						<div id="play-multimedia-video" data-video-src="2eIWmzzuuo4"><i class="icon icon-play_btn"></i>
						</div>
					</div>
					<a href="http://leideincentivoacultura.cultura.gov.br/multimedia" class="btn btn-ver-mais">Mais
						Vídeos</a>
				</div>
			</div>
		</section>
		-->
</main>

<?php get_footer(); ?>

