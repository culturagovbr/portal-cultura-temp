<?php
/**
 * The template for displaying category results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Identidade_Digital_do_Governo_-_WordPress
 */

get_header();
?>

  <main id="main" class="site-main">
    <div class="container">
      <div class="row">
        <?php the_breadcrumb(); ?>
      </div>

      <div id="content" class="row">
        <div class="col-12">

          <h1 class="page-title text-center">
            <?php echo get_cat_name(get_query_var('cat')); ?>
          </h1>

          <div id="search-content-wrapper">
            <!-- <h2>O que você esta procurando?</h2> -->
            <form id="search-content">
              <div class="input-wrapper">
                <input type="text" name="search" placeholder="Buscar" />
                <button type="submit" class="search"><i class="icon-search"></i></button>
                <button type="button" class="filter">Filtrar</button>
              </div>

              <div class="filter-wrapper">

                <label><input type="checkbox" name="andamento" /> Em Andamento</label>
                <label><input type="checkbox" name="inscricoes" /> Inscrições Abertas</label>
                <label><input type="checkbox" name="finalizados" /> Finalizados</label>

                <button type="button" class="apply">Aplicar</button>
              </div>
            </form>
          </div>

          <?php get_template_part('template-parts/posts-list', 'category'); ?>

          <?php get_template_part('template-parts/copyright'); ?>
        </div>
      </div>
    </div>
  </main>

<?php
get_footer();
