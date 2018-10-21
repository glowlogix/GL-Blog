<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Glowlogix Blog
 */

get_header();
?>

	<div class="error-page-wrap">
  <div class="container">
    <div class="errormain">
      <h2>404</h2>
      <h3>Page was not Found</h3>
      <div class="error-msg">
        <p>The page you are looking is not available or has been removed. Try going to Home Page by using the button below.</p>
        <a href="<?php site_url();?>" class="btn">Go to Home Page</a> </div>
    </div>
  </div>
</div>

<?php
get_footer();
