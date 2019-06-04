<?php
global $post;
$children = get_pages( array( 'child_of' => $post->ID ) );?>

<?php if ( is_page() && count( $children ) > 0 ) : ?>
  <?php $pageId = $post->ID; ?>
<?php else : ?>
  <?php $pageId = $post->post_parent; ?>
<?php endif; ?>

<?php
  $args = array(
    'post_parent' => $pageId,
    'post_type' => 'page',
    'orderby' => 'menu_order',
    'post__not_in' => array($post->ID)
  );

  $child_query = new WP_Query( $args );
?>

<?php wp_reset_postdata(); ?>

<?php if ($child_query->have_posts()) : ?>

  <div class="menu-wrapper subpages-menu">
    <div class="menu-content">

      <?php $pagesHighlight = 2; ?>

      <?php $i=0; while ( $child_query->have_posts() ) : $child_query->the_post(); $i++; ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>

        <?php if ($i >= $pagesHighlight) { break; }; ?>
      <?php endwhile; ?>

      <?php if ($child_query->post_count > $pagesHighlight) : ?>
        <button type="button" class="icon-plus toggle-active"></button>

        <ul>
          <?php $i=0; while ( $child_query->have_posts() ) : $child_query->the_post(); $i++; ?>
            <?php //if ($i > $pagesHighlight) : ?>
              <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
            <?php //endif; ?>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>

<?php endif; ?>