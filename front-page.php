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
                <h4 class="home-type-title">Carmen Santos</h4>
            </div>
            <div class="col-xs-6 no-padding">
                <h5 cass="pull-right" style="text-align: right;"><a href="<?php echo get_site_url(); ?>/colecao/filme-cultura/">Busca avançada</a></h5> 
            </div>
        </div>
        <div class="home-container carousel-home">
            <?php
                $carmen =  get_children( array('post_parent' => 24) );
                //var_dump($child_post);die;
                //$child_items =  wp_get_recent_posts( [ 'post_type' => 'socialdb_object', 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'DESC'] );
                foreach ($carmen as $item):
                    ?>
                    <div class="col-md-12 col-sm-12 featured" style="width: 215px !important;">
                        <div class="col-md-12 col-sm-12 blocos">
                            <div class="item-individual-box">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <a href="<?php echo $item->guid; ?>">
                                            <?php if ( has_post_thumbnail($item->ID) ) : ?>
                                                <?php echo get_the_post_thumbnail( $item->ID, 'medium'); ?>
                                            <?php else : ?>
                                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/header.png'; ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="panel-footer home-title">
                                        <a href="<?php echo $item->guid; ?>">
                                            <span class="collection-name"> <?php echo wp_trim_words($item->post_title, 20) ?> </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            ?>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding">
                <h4 class="home-type-title">Catálogo de Filmes</h4>
            </div>
        </div>
        <div class="home-container carousel-home catalogofilmes">
            <?php
                $filmes =  get_children( array('post_parent' => 38, 'numberposts' => 500) );
                foreach ($filmes as $item):
                    ?>
                    <div class="col-md-12 col-sm-12 featured" style="width: 215px !important;">
                        <div class="col-md-12 col-sm-12 blocos">
                            <div class="item-individual-box">
                                <div class="panel panel-default filmes">
                                    <div class="panel-body">
                                        <a href="<?php echo $item->guid; ?>">
                                            <?php if ( has_post_thumbnail($item->ID) ) : ?>
                                                <?php echo get_the_post_thumbnail( $item->ID, 'medium'); ?>
                                            <?php else : ?>
                                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/header.png'; ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="panel-footer home-title">
                                        <a href="<?php echo $item->guid; ?>">
                                            <span class="collection-name"> <?php echo wp_trim_words($item->post_title, 20) ?> </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; 
            ?>
        </div>
    </div>

<?php }
//var_dump($child_items);
get_template_part("partials/setup","header");

get_template_part("footer","front");
