<?php get_header(); ?>
<div class="o-container u-margin-bottom-40">
    <div class="o-row">
        <div class="o-row__column o-row__column--span-<?php echo is_active_sidebar( 'primary-sidebar' ) ? '8' : '12'; ?>@medium">
            <main role="main">
                <?php if (have_posts()) { ?>
                    <?php while (have_posts()) { ?>
                        <?php the_post(); ?>
                        <article <?php post_class('c-post u-margin-bottom-20'); ?>>
                            <h2>
                                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2
                            <div>
                                <?php _themename_post_meta() ?>
                            </div>
                            <div>
                                <?php the_excerpt(); ?>
                            </div>
                            <?php _themename_readmore_link() ?>
                        </article>
                    <?php } ?>
                    <div>
                        <?php the_posts_pagination() ?>
                    </div>
                <?php } else { ?>
                    <h4><?php echo apply_filters('_themename_no_posts_text', esc_html__('Sorry no posts found!', '_themename')) ?></h4>
                <?php } ?>
                <?php do_action('_themename_after_pagination'); ?>
            </main>
            <div class="o-row__column o-row__column--span-12 o-row__column--span-4@medium">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>