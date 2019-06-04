<?php /* Template Name: Secretarias */ ?>

<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Identidade_Digital_do_Governo_-_WordPress
 */

get_header();
?>

  <main id="main" class="site-main">

    <div class="container">
      <?php the_breadcrumb (); ?>

      <div class="row">
        <div class="col-12">

          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
              <h1 class="entry-title"><?php single_cat_title(); ?></h1>
            </header>

            <div class="entry-content mb-5">
              <?php echo category_description( ); ?> 
            </div>
          </article>

          <hr/>

        </div>
      </div>
    </div>


    <div class="container mt-4">
      <div class="col-12 pt-4 pb-4">
        <div id="search-content-wrapper">
          <h2 class="text-center">Notícias</h2>
        </div>

        <div class="row">
          <?php get_template_part('template-parts/posts-list', 'category'); ?>
        </div>
      </div>
    </div>
  </main>
<?php
get_footer();
