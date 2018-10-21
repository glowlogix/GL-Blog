<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Glowlogix Blog
 */

get_header();
?>
<div class="listingWrap">
	<div class="container"> 
		<header class="page-header">
			<h1 class="pageTitle">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'glblog' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header><!-- .page-header -->
		<div class="row">
			<div class="col-md-8"> 
				<div class="blogWraper">
					<ul class="blogList">
						<?php if ( have_posts() ) : ?>
							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();
								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );
							endwhile;
						else :
							get_template_part( 'template-parts/content', 'none' );
						endif;
						?>
					</ul>
					<div class="pagiWrap">
					    <div class="row">
					      <div class="col-md-4 col-sm-6">
					        <!--  <div class="showreslt">Showing 1-10</div> -->
					      </div>
					      <div class="col-md-8 col-sm-6 text-right">         
					        <?php glblog_pagination();?>
					      </div>
					    </div>
					  </div>
				</div>
			</div>
			<div class="col-md-4">
				<?php get_sidebar();?>
			</div>
		</div>
<?php
get_footer();
