<?php
$front = [ 'config' => get_option('show_on_front'), 'page' => get_option('page_on_front')];
get_template_part("header","front");
?>
<div class="container no-padding">
    <header class="banner" style="background-image: url('<?php header_image(); ?>'); ">
        <div class="especificacao">
            <h1 class="title hide"><?php bloginfo('name') ?></h1>
            <span class="sub-title"><?php nl2br(bloginfo('description')) ?></span>
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
        <div class="row">
            <div class="col-xs-6 no-padding">
                <h4 class="home-type-title">Edições da Revista</h4>
            </div>
            <div class="col-xs-6 no-padding">
                <h5 cass="pull-right" style="text-align: right;"><a href="<?php echo get_site_url(); ?>/colecao/filme-cultura/">Busca avançada</a></h5> 
            </div>
        </div>
        <div class="home-container carousel-home">

            <?php
                $child_items =  wp_get_recent_posts( [ 'post_type' => 'socialdb_object', 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'DESC'] );
                //var_dump($child_items);die;
            foreach ($child_items as $item):
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
                                                        <?php echo get_the_post_thumbnail( $item['ID'], 'medium'); ?>
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

get_template_part("footer","front");
