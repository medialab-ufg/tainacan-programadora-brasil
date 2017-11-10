<?php
function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
    wp_enqueue_script( 'tainacan_child_js', get_template_directory_uri() . '-child/assets/js/script.js', '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function tainacan_child_script(){
    $parent_style = 'parent-style';
    wp_enqueue_script( 'tainacan_child_js', get_template_directory_uri() . '/assets/js/script.js', array( $parent_style ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'tainacan_child_script' );

//Register Meta Box
function objetos_metabox() {
    add_meta_box( 'objetos_metabox_id', __( 'Objetos Relacionados' ), 'objetos_metabox_callback', 'post' );
}
add_action( 'add_meta_boxes', 'objetos_metabox');
 
//Add field

function objetos_metabox_callback(){
    global $post;
    wp_nonce_field( $post->ID, 'objetos_metabox_nonce' );
    $relacionados =  wp_get_recent_posts( [ 'post_type' => 'socialdb_object', 'numberposts' => -1, 'post_status' => 'publish', 'orderby' => 'post_title', 'order' => 'DESC'] );
    $stored_meta = get_post_meta( $post->ID, 'objetos_metabox' );
    ?>
    <div style="max-height: 201px; overflow: auto;">
        <?php
            foreach ($relacionados as $rel) {
            //var_dump($relacionados); die;
            ?>   
                <input type="checkbox" name="objetos_metabox[]" id="objetos_<?php echo $rel['ID']; ?>" value="<?php echo $rel['ID']; ?>" 
                    <?php 
                        if(isset($stored_meta[0][0])) {
                            $count = count($stored_meta[0][0]) - 1;
                            for($x=0; $x<=$count; $x++){
                                checked( $stored_meta[0][0][$x], $rel['ID'] );
                            }
                        }
                    ?>
                > 
                <label for="objetos_<?php echo $rel['ID']; ?>" style="margin-top: 5px; margin-bottom: 1px;">
                    <?php echo $rel['post_title']; ?>
                </label>
                <br>
            <?php
            }
        ?>
    </div>
<?php
}

function objetos_metabox_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'objetos_metabox_nonce' ] ) && wp_verify_nonce( $_POST[ 'objetos_metabox_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'objetos_metabox' ] ) ) {
        update_post_meta( $post_id, 'objetos_metabox', array($_POST[ 'objetos_metabox' ]) );
    }
 
}
add_action( 'save_post', 'objetos_metabox_save' );

//Criando o hook
function objetos_hook(){
    do_action( 'header_sidebar_item' );
}

//função que retorna o resultado dos post meta pelo meta_key
function tainacan_fc_get_post_meta($meta_key) {
    global $wpdb;
    $query = "SELECT * FROM $wpdb->postmeta WHERE meta_key = '$meta_key'";
    $result = $wpdb->get_results($query);
    if ($result &&  is_array($result)) {
        return $result;
    } elseif ($result && isset($result->ID)) {
        return $result;
    } else {
        return false;
    }
}

/*
* Function que verifca se o objeto esta relacionado ao post no postmeta
* @param $object_id id do objeto
*/
function has_relation($object_id){
    $stored_meta = tainacan_fc_get_post_meta( 'objetos_metabox' );
    foreach ($stored_meta as $value) {
        $postmeta = get_post_meta( $value->post_id, 'objetos_metabox', true );

        if($postmeta[0][0] == $object_id)
            $x = true;
        else
            $x = false;
    }
    if($x)
        return true;
    else
        return false;
}

function objetos_list($object_id){
    $stored_meta = tainacan_fc_get_post_meta( 'objetos_metabox' );
    
    if(!empty($stored_meta) && has_relation($object_id)){ ?>
    
        <h3 id="text_title">
            <?php _e('Posts Relacionados', 'tainacan'); ?>
            <br>
        </h3>    
        <hr>
        <?php
        foreach ($stored_meta as $meta) { ?>
            <h4 style="border-bottom: 1px dashed #CCCCCC; padding-bottom: 8px; width: 80%; margin: 10px auto;">
                <?php if(has_post_thumbnail( $meta->post_id )) { ?>    
                    <img src="<?php echo get_the_post_thumbnail_url( $meta->post_id, $size = 'post-thumbnail' ); ?>" alt="" class="img-responsive" style="display: inline-block; max-width: 45px; float: left; margin-right: 5px;"/>
                <?php } ?>
                <a href="<?php the_permalink( $meta->post_id ); ?>" class="text-uppercase" style="color: black; font-weight: bold; font-size: 14px;">
                    <?php echo get_the_title( $meta->post_id ); ?>
                </a>
            </h4> 
        <?php } ?>
    <hr>
    <?php }
}

add_action( 'header_sidebar_item', 'objetos_list');