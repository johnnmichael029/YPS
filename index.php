<?php
/**
 * YPS Gaming Theme - Index Template
 * Fallback template
 */
get_header();
?>
<div class="yps-container" style="padding: calc(var(--nav-height) + 60px) 0 80px; min-height: 60vh;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>">
            <h1 style="font-size:2rem;font-weight:900;margin-bottom:20px;"><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
        </article>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
