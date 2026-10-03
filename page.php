<?php
/**
 * YPS Gaming Theme - Default Page Template
 */
get_header();
?>
<div class="yps-page-hero">
    <div class="yps-container">
        <div class="page-hero-content">
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
</div>
<div class="yps-container" style="padding: 60px 24px 80px; max-width: 800px;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="page-content" style="font-size:1rem;line-height:1.8;color:#444;">
            <?php the_content(); ?>
        </div>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
