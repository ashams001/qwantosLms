<?php
/**
 * @package thimpress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-format-right-sidebar' ); ?>>
    <div class="content clearfix">
        <div class='col-md-9 post-formats-wrapper be-section'>
		    <?php
		    if ( get_post_meta( get_the_ID(), 'portfolio_sliders', true ) ) {
			    echo '<div class="be-section">';
			    $images = get_post_meta( get_the_ID(), 'portfolio_sliders', false );
			    foreach ( $images as $att ) {
				    echo '<div class="be-animate" data-animation="slideInLeft"><p>';
				    if ( substr( $att, 0, 2 ) == 'v.' ) {
					    echo '<iframe src="http://player.vimeo.com/video/' . substr( $att, 2 ) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="auto" height="500px" frameborder="0"></iframe>';
				    } elseif ( substr( $att, 0, 2 ) == 'y.' ) {
					    echo '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="auto" height="500px" src="http://www.youtube.com/embed/' . substr( $att, 2 ) . '" frameborder="0"></iframe>';
				    } else {
					    // Get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
					    $src = wp_get_attachment_image_src( $att, 'full' );
					    $src = $src[0];
					    // Show image
					    echo "<img src='{$src}' />";
				    }
				    echo '</p></div>';
			    }
			    echo '</div>';
		    } elseif ( has_post_thumbnail( get_the_ID() ) ) {
			    echo '<div class="be-section">';
			    echo '<div class="be-animate" data-animation="slideInLeft"><p>';
			    echo get_the_post_thumbnail( get_the_ID(), 'full' );
			    echo '</p></div>';
			    echo '</div>';
		    } else {
			    // do nothing
		    }
		    ?>
        </div>
        <div class="col-md-3 entry-content-portfolio floting-sidebar">
            <div class="entry-content-right">
                <section class="portfolio-description">
                    <h3><?php echo esc_html__( 'Project description', 'course-builder' ); ?></h3>
				    <?php the_content(); ?>
                </section>

			    <?php
			    $taxonomy = 'portfolio_category';
			    $terms    = get_the_terms( get_the_ID(), $taxonomy ); // Get all terms of a taxonomy
			    if ( $terms && ! is_wp_error( $terms ) ) :
				    echo '<section class="tags"><i class="fa fa-tags">&nbsp;</i><ul>';
				    ?>
				    <?php foreach ( $terms as $term ) { ?>
                    <li>
                        <a href="<?php echo esc_url( get_term_link( $term->slug, $taxonomy ) ); ?>"><?php echo $term->name; ?></a>
                    </li>
			    <?php } ?>
				    <?php
				    echo '</ul></section>';
			    endif;
			    ?>

			    <?php if ( get_post_meta( get_the_ID(), 'project_link', true ) ) { ?>
                    <div class="link-project">
                        <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'project_link', true ) ); ?>" target="_blank"
                           class="sc-btn"><?php esc_html_e( 'Link project', 'course-builder' ); ?></a>
                    </div>
			    <?php } ?>

			    <?php
			    wp_link_pages( array(
				    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'course-builder' ),
				    'after'  => '</div>',
			    ) );
			    ?>
            </div>
        </div>
    </div>
	<?php thim_related_portfolio( get_the_ID() ); ?>

</article><!-- #post-## -->
