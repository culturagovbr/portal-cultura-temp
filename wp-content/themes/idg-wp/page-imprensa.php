<?php /* Template Name: Imprensa */ ?>

<?php get_header(); ?>

<main id="page-imprensa" class="site-main">
  <div class="container">
    <div class="row">
      <?php the_breadcrumb(); ?>
    </div>

    <?php wp_reset_postdata(); ?>

  </div>

  <div id="content">
    <div class="container">
      <header class="entry-header">
        <h1 class="entry-title text-center"><?php the_title(); ?></h1>
      </header>
    </div>
  </div>

  <div id="contact">
    <div class="container">
      <div class="row">
        <div class="col text-wrapper">
          <?php the_content(); ?>
        </div>

        <div class="col form-wrapper">
          <?php echo do_shortcode('[contact-form-7 id="279299" title="Imprensa"]'); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <div class="col-12 pt-4 pb-4">
      <div id="search-content-wrapper">
        <h2 class="text-center">Avisos de Pauta e Releases</h2>
      </div>

      <div class="row">
        <?php

        $args = array(
          'posts_per_page' => 3,
          'category_name'  => 'imprensa'
        );

        $news_query = new WP_Query( $args ); ?>

        <?php if ($news_query->have_posts()) : ?>
          <ul id="posts-list">

            <?php while ($news_query->have_posts()) : ?>
              <?php $news_query->the_post(); ?>

              <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="categories"><?php the_category(', '); ?></div>

                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php echo idg_excerpt(); ?></p>

                <?php if (get_the_tags()) : ?>
                  <div class="tags-list">
                    <?php the_tags('<span>tags:</span>', ''); ?>
                  </div>
                <?php endif; ?>

                <span class="details">
                  por Ascom<?php // the_author_posts_link(); ?>
                  última modificação em <?php the_modified_date('d/m/Y'); ?> <?php the_modified_time('H'); ?>
                  h<?php the_modified_time('i'); ?>
                </span>
              </li>

            <?php endwhile; ?>

            <?php if ( function_exists('wp_bootstrap_pagination') ){
              wp_bootstrap_pagination();
            }; ?>


          </ul>

        <?php else : ?>

          <?php get_template_part('template-parts/content', 'none'); ?>

        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>


