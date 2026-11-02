<?php
// Any new page created in the editor uses the site hero and a readable text column.
get_header();
the_post();
jet_page_hero();
?>
<section class="mx-auto max-w-3xl px-5 pb-24 pt-4 sm:px-8">
	<div class="jet-prose"><?php the_content(); ?></div>
</section>
<?php
get_footer();
