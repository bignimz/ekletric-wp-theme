<?php get_header(); ?>


    <?php if (have_posts()) { ?>
        <?php while (have_posts()) { ?>
            <?php the_post(); ?>
            <h2>
                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a>
            </h2
            <div>
               <?php _themename_post_meta() ?>
            </div>
            <div>
                <?php the_excerpt(); ?>
            </div>
            <?php _themename_readmore_link() ?>
        <?php } ?>
        <div>
            <?php the_posts_pagination() ?>
        </div>
    <?php } else { ?>
        <h4><?php echo apply_filters('_themename_no_posts_text', esc_html__('Sorry no posts found!', '_themename')) ?></h4>
    <?php } ?>
    <?php do_action('_themename_after_pagination'); ?>
    <?php 
    $comments = 3;
    printf(_n('One comment', '%s comments', $comments, '_themename'), $comments);
    ?>

<?php get_footer(); ?>