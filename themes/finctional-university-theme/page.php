<?php
    get_header();

    while (have_posts()) {
        the_post();
        pageBanner(); 
        /* pageBanner(array(
            'title' => 'Hello, this is the big title',
            'subtitle' => 'Hi, this is the subtitle',
            'photo' => 'https://images.unsplash.com/photo-1533431718451-44f4ccde21a0?ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80'
        )); */
        ?>

        <div class="container container--narrow page-section">
            <?php
            $theParent = wp_get_post_parent_id(get_the_ID());
            if ($theParent) {?>
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
                </div>
            <?php }
            ?>
            
             <?php 
                $testArray = get_pages(array(
                    'child_of' => get_the_ID()
                ));
                
                if ($theParent or $testArray) { ?>
            <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
            <ul class="min-list">
                <?php
                    if ($theParent) {
                        $findChildrenOf = $theParent;
                    } else {
                        $findChildrenOf = get_the_ID();
                    }

                    wp_list_pages(array(
                        'title_li' => NULL, // removes (Pages) title for all pages
                        'child_of' => $findChildrenOf,
                        'sort_column' => 'menu_order'
                    ));
                ?>
            </ul>
            </div>
            <?php } ?>
             
            <div class="generic-content">
                <?php the_content(); ?>
            </div>

        </div>

    <?php }

        get_footer();
?>