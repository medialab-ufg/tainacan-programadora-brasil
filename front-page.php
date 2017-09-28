<?php
$front = [ 'config' => get_option('show_on_front'), 'page' => get_option('page_on_front')];
get_header();
?>
<div class="container no-padding">
    <header class="banner">
        <div class="especificacao">
            <p class="title"><?php bloginfo('name') ?></p>
            <p class="sub-title"><?php bloginfo('description') ?></p>
            <span>
                Bacon ipsum dolor amet beef turkey cupim porchetta sausage chicken jerky
                bresaola. Sausage cow swine ham hock rump meatloaf. Brisket capicola meatball,
                short loin beef ribs turkey ground round leberkas porchetta ball tip prosciutto
                turducken. Cow strip steak t-bone ham hock leberkas, meatball doner corned beef
                swine.
                Pork loin venison ham leberkas ground round. Kevin pancetta boudin alcatra strip
                steak porchetta ground round bilton`tg. Bresaola ank andouille kielbasa picanha
                porchetta, t-bone ham hock salami pork rump ground round strip steak pork belly
                meatball. Meatball t-bone pancetta shoulder. Frankfurter pork sirloin pork chop
                shankle landjaeger.
            </span>
        </div>
        
    </header>
</div>
    <?php
// Se usuário escolheu uma página para ser a Home
 if( "page" === $front['config'] ) {
     $_menu_ = ['container_class' => 'container', 'container' => false, 'walker' => new wp_bootstrap_navwalker(), 'menu_class' => 'navbar navbar-inverse menu-ibram'];
     $page_template = get_page_template_slug($front['page']);

     wp_nav_menu($_menu_);

     if('template-home.php' === $page_template) {
         load_template(dirname( __FILE__ ) . '/template-home.php');
     }

    // Ou se escolheu "Seus posts recentes" para ser a home (padrão da instalação WP)
 } else { ?>

    <div id="display_view_main_page_" class="container">
        
        <div class="home-container carousel-home">

            <?php 
                $child_items = [
                        'title' => 'Itens em destaque',
                        'data' => wp_get_recent_posts( [ 'post_type' => 'socialdb_object', 'numberposts' => -1] )
                ];
            foreach ($child_items['data'] as $item):
                if ( is_array($item) && !empty($item) ):
                    ?>
                    <div class="col-md-12 col-sm-12 featured" style="width: 215px !important;">
                        <div class="col-md-12 col-sm-12 blocos">
                                <div class="item-individual-box">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <a href="<?php echo $item['guid']; ?>">
                                                <?php
                                                /* $item_id = $item['ID'];
                                                $output = "";
                                                $collection_name = explode(" ", $item['post_title']);
                                                if (has_post_thumbnail($item_id)):
                                                    $output = get_item_thumb_image($item_id);
                                                endif;
                                                if (empty($output)) {
                                                    echo '<div class="tainacan-thumbless">';
                                                        format_home_items_char($collection_name[0]) . format_home_items_char($collection_name[1]);
                                                    echo '</div>';
                                                } else {
                                                    echo $output;
                                                } */
                                                ?>
                                                <?php if ( has_post_thumbnail($item['ID']) ) : ?>
                                                    <a href="<?php echo $item['guid']; ?>">
                                                        <img src="<?php echo get_the_post_thumbnail_url($item['ID']) ?>" alt="" class="img_responsive">
                                                    </a>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="panel-footer home-title">
                                            <a href="<?php echo $item['guid']; ?>">
                                                <span class="collection-name"> <?php echo wp_trim_words($item['post_title'], 20) ?> </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
    </div>

<?php }
//var_dump($child_items);
get_template_part("partials/setup","header");
get_footer();
