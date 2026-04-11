<?php
/**
 * sts-capital functions and definitions
 */

if ( ! function_exists( 'sts_capital_setup' ) ) :
    function sts_capital_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

        register_nav_menus( array(
            'menu-1' => esc_html__( 'Primary', 'sts-capital' ),
            'footer' => esc_html__( 'Footer', 'sts-capital' ),
        ) );

        // Add Custom Logo Support
        add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

        // Create Leads Table on Theme Setup
        global $wpdb;
        $table_name = $wpdb->prefix . 'sts_newsletter_leads';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            email varchar(100) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        // Register Installer Role
        add_role( 'instalador_parceiro', 'Instalador Parceiro', array( 'read' => true, 'edit_posts' => false, 'upload_files' => true ) );

        // Optimization: Disable emoji and other bloat
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }
endif;
add_action( 'after_setup_theme', 'sts_capital_setup' );

/**
 * Add social links and expertise to user profile for E-E-A-T
 */
function sts_capital_user_contact_methods($user_contact) {
    $user_contact['expertise'] = 'Expertise/Cargo (ex: Analista de Pesquisa)';
    $user_contact['linkedin']  = 'Link do LinkedIn';
    $user_contact['twitter']   = 'Link do Twitter';
    $user_contact['website']   = 'Site Pessoal/Portfólio';
    return $user_contact;
}
add_filter('user_contactmethods', 'sts_capital_user_contact_methods');

/**
 * Generate Table of Contents (TOC) from H2 headers
 */
function sts_capital_get_toc() {
    global $post;
    $content = $post->post_content;
    preg_match_all('/<h2.*?>(.*?)<\/h2>/', $content, $matches);

    if ( empty($matches[1]) ) return '';

    $html = '<details class="toc-container group bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl mb-12 overflow-hidden transition-all duration-300">';
    $html .= '<summary class="list-none cursor-pointer p-6 flex items-center justify-between select-none">';
    $html .= '  <div class="flex items-center gap-3">';
    $html .= '    <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings:\'FILL\' 1">list</span>';
    $html .= '    <span class="text-[11px] font-black uppercase tracking-[0.2em] text-on-surface">Índice de Navegação</span>';
    $html .= '  </div>';
    $html .= '  <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform duration-300">expand_more</span>';
    $html .= '</summary>';
    
    $html .= '<div class="px-8 pb-8 pt-2 border-t border-slate-100 dark:border-slate-800/50">';
    $html .= '<ul class="space-y-4 list-none p-0 m-0">';
    
    foreach ($matches[1] as $index => $title) {
        $slug = sanitize_title($title);
        $html .= '<li><a href="#' . $slug . '" class="text-[11px] font-bold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors flex items-center gap-4 group/item">';
        $html .= '<span class="text-[9px] w-6 h-6 flex items-center justify-center bg-slate-200 dark:bg-slate-800 rounded group-hover/item:bg-primary group-hover/item:text-white transition-all text-slate-400">0' . ($index + 1) . '</span>';
        $html .= strip_tags($title) . '</a></li>';
    }
    
    $html .= '</ul></div></details>';
    $html .= '<style>.toc-container summary::-webkit-details-marker { display: none; }</style>';
    
    return $html;
}

/**
 * Add IDs to H2 tags in content
 */
function sts_capital_add_ids_to_headers($content) {
    if ( is_single() ) {
        $content = preg_replace_callback('/<h2(.*?)>(.*?)<\/h2>/', function($matches) {
            $slug = sanitize_title($matches[2]);
            return '<h2' . $matches[1] . ' id="' . $slug . '">' . $matches[2] . '</h2>';
        }, $content);
    }
    return $content;
}
add_filter('the_content', 'sts_capital_add_ids_to_headers');

function sts_capital_scripts() {
    wp_enqueue_style( 'sts-capital-style', get_stylesheet_uri(), array(), '1.1.0' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Inter:wght@100..900&display=swap', array(), null );
    wp_enqueue_style( 'material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null );
    
    // Tailwind CDN for the specific design requested
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com?plugins=forms,container-queries', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'sts_capital_scripts', 10 );

/**
 * Inject Tailwind Config & Custom Styles into head
 */
function sts_capital_tailwind_config() {
    ?>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-secondary-fixed-variant": "#004b73",
                    "on-secondary": "#ffffff",
                    "on-tertiary-fixed": "#390c00",
                    "tertiary": "#98472a",
                    "inverse-primary": "#4ae183",
                    "error": "#ba1a1a",
                    "surface-bright": "#f7f9ff",
                    "on-error": "#ffffff",
                    "inverse-surface": "#203243",
                    "on-primary-container": "#005027",
                    "surface-container-low": "#edf4ff",
                    "surface-container": "#e3efff",
                    "outline-variant": "#bbcbbb",
                    "secondary-fixed-dim": "#92ccff",
                    "on-tertiary": "#ffffff",
                    "on-error-container": "#93000a",
                    "tertiary-container": "#ff9875",
                    "on-primary": "#ffffff",
                    "primary": "#006d37",
                    "tertiary-fixed-dim": "#ffb59d",
                    "on-primary-fixed": "#00210c",
                    "surface": "#f7f9ff",
                    "on-secondary-container": "#00476e",
                    "tertiary-fixed": "#ffdbd0",
                    "surface-container-highest": "#d1e4fb",
                    "surface-container-high": "#d9eaff",
                    "primary-fixed": "#6bfe9c",
                    "error-container": "#ffdad6",
                    "surface-variant": "#d1e4fb",
                    "on-tertiary-container": "#772e14",
                    "on-primary-fixed-variant": "#005228",
                    "on-surface-variant": "#3d4a3e",
                    "background": "#f7f9ff",
                    "on-background": "#091d2e",
                    "on-secondary-fixed": "#001d31",
                    "surface-container-lowest": "#ffffff",
                    "surface-dim": "#c9dcf3",
                    "secondary": "#006397",
                    "secondary-container": "#5cb8fd",
                    "outline": "#6c7b6d",
                    "on-tertiary-fixed-variant": "#793015",
                    "surface-tint": "#006d37",
                    "primary-container": "#2ecc71",
                    "primary-fixed-dim": "#4ae183",
                    "inverse-on-surface": "#e8f2ff",
                    "on-surface": "#091d2e",
                    "secondary-fixed": "#cce5ff"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "fontFamily": {
                    "headline": ["Manrope"],
                    "body": ["Inter"],
                    "label": ["Inter"]
            }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .article-content h2 { font-family: 'Manrope', sans-serif; font-size: 2rem; font-weight: 700; color: #091d2e; margin-top: 2.5rem; margin-bottom: 1.25rem; letter-spacing: -0.02em; }
        .article-content h3 { font-family: 'Manrope', sans-serif; font-size: 1.5rem; font-weight: 600; color: #091d2e; margin-top: 2rem; margin-bottom: 1rem; }
        .article-content p { font-family: 'Inter', sans-serif; font-size: 1.125rem; line-height: 1.75; color: #091d2e; margin-bottom: 1.5rem; }
        .glass-panel { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        
        /* FIX: Forçar Anúncio Billboard Superior a ROLAR com a página */
        .sts-ad-top_billboard {
            position: relative !important;
            display: block !important;
            z-index: 10 !important;
            margin-top: 0 !important;
            clear: both;
        }

        /* WordPress Admin Bar fix */
        body.admin-bar .fixed.top-0 { top: 32px !important; }
        @media (max-width: 782px) {
            body.admin-bar .fixed.top-0 { top: 46px !important; }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'sts_capital_tailwind_config' );


/**
 * Cloudflare Turnstile Configuration
 */
define('CF_TURNSTILE_SITE_KEY', '0x4AAAAAAC3rTM2cujUshIxC');
define('CF_TURNSTILE_SECRET_KEY', '0x4AAAAAAC3rTAyqlpX383ubm30o448u2v0');

function sts_verify_turnstile($token) {
    if ( empty($token) ) return false;
    $response = wp_remote_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', array(
        'body' => array(
            'secret'   => CF_TURNSTILE_SECRET_KEY,
            'response' => $token,
        ),
    ));
    if ( is_wp_error($response) ) return false;
    $body = json_decode(wp_remote_retrieve_body($response));
    return $body->success;
}

/**
 * Item 7: Native Cloudflare Edge Connector
 */
define('CLOUDFLARE_ZONE_ID', '2d6886d593ee13b3bc131af7087fc0c2');
define('CLOUDFLARE_EMAIL', 'wrsouza10@hotmail.com');
define('CLOUDFLARE_API_KEY', '4c70a37f68c6ebdacf1e28f3fe68d8516f7bc');

function sts_capital_cloudflare_purge_cache() {
    $url = 'https://api.cloudflare.com/client/v4/zones/' . CLOUDFLARE_ZONE_ID . '/purge_cache';
    
    $args = array(
        'method'  => 'POST',
        'headers' => array(
            'X-Auth-Email' => CLOUDFLARE_EMAIL,
            'X-Auth-Key'   => CLOUDFLARE_API_KEY,
            'Content-Type' => 'application/json',
        ),
        'body'    => json_encode(array('purge_everything' => true)),
    );

    wp_remote_post($url, $args);
}

// Purge cache when content changes
add_action('save_post', 'sts_capital_cloudflare_purge_cache', 100);
add_action('deleted_post', 'sts_capital_cloudflare_purge_cache', 100);
add_action('switch_theme', 'sts_capital_cloudflare_purge_cache');

// Add a "Purge Cloudflare" button to the Admin Bar
function sts_capital_admin_bar_purge($wp_admin_bar) {
    if ( !current_user_can('manage_options') ) return;
    $wp_admin_bar->add_node(array(
        'id'    => 'purge_cloudflare',
        'title' => '<span class="ab-icon dashicons dashicons-cloud"></span> Limpar Cache Cloudflare',
        'href'  => admin_url('admin-ajax.php?action=sts_manual_purge_cf'),
    ));
}
add_action('admin_bar_menu', 'sts_capital_admin_bar_purge', 100);

function sts_capital_manual_purge_cf() {
    sts_capital_cloudflare_purge_cache();
    wp_redirect(wp_get_referer());
    exit;
}
add_action('wp_ajax_sts_manual_purge_cf', 'sts_capital_manual_purge_cf');

/**
 * Item 6: Solar Business Hub
 */
function sts_capital_register_instalador_cpt() {
    $labels = array(
        'name'                  => 'Instaladores',
        'singular_name'         => 'Instalador',
        'menu_name'             => 'Instaladores Solares',
        'add_new'               => 'Novo Instalador',
        'add_new_item'          => 'Adicionar Novo Instalador',
        'edit_item'             => 'Editar Instalador',
        'new_item'              => 'Novo Instalador',
        'view_item'             => 'Ver Instalador',
        'search_items'          => 'Buscar Instalador',
        'not_found'             => 'Nenhum instalador encontrado',
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'instaladores'),
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments' ),
        'menu_icon'          => 'dashicons-hammer',
        'show_in_rest'       => true,
    );
    register_post_type( 'instalador', $args );
}
add_action( 'init', 'sts_capital_register_instalador_cpt' );

// Taxonomy for Regions (State > City)
function sts_capital_register_regiao_taxonomy() {
    register_taxonomy( 'regiao', 'instalador', array(
        'label'        => 'Estado / Cidade',
        'rewrite'      => array( 'slug' => 'instaladores-em' ),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action( 'init', 'sts_capital_register_regiao_taxonomy' );

/// Custom Columns for Installer List in Admin
function sts_set_instalador_columns($columns) {
    unset($columns['date']);
    $columns['sts_logo'] = 'Logo';
    $columns['title'] = 'Empresa';
    $columns['sts_location'] = 'Localização';
    $columns['sts_premium'] = 'Status Premium';
    $columns['date'] = 'Data';
    return $columns;
}
add_filter('manage_instalador_posts_columns', 'sts_set_instalador_columns');

function sts_capital_fill_instalador_columns($column, $post_id) {
    switch ($column) {
        case 'sts_logo':
            echo get_the_post_thumbnail($post_id, array(40, 40), array('style' => 'border-radius:8px; border:1px solid #ddd'));
            break;
        case 'sts_location':
            $terms = wp_get_post_terms($post_id, 'regiao');
            if ( !empty($terms) ) {
                $city = $terms[0]->name;
                $state = ($terms[0]->parent) ? get_term($terms[0]->parent, 'regiao')->name : 'N/A';
                echo "<strong>$city</strong><br><small>$state</small>";
            } else { echo '—'; }
            break;
        case 'sts_premium':
            $is_premium = get_post_meta($post_id, '_sts_is_premium', true);
            if ($is_premium === '1') {
                echo '<span style="background:#fff3cd; color:#856404; padding:4px 10px; border-radius:12px; font-weight:bold; font-size:10px; border:1px solid #ffeeba">⭐ PREMIUM</span>';
            } else {
                echo '<span style="background:#f8f9fa; color:#6c757d; padding:4px 10px; border-radius:12px; font-weight:bold; font-size:10px; border:1px solid #dee2e6">GRATUITO</span>';
            }
            break;
    }
}
add_action('manage_instalador_posts_custom_column', 'sts_capital_fill_instalador_columns', 10, 2);

/**
 * Metaboxes para o instalador
 */
function sts_capital_add_instalador_meta() {
    // Esconder o metabox padrão de 'regiao' para usar o nosso customizado
    remove_meta_box('regiaodiv', 'instalador', 'side');
    
    add_meta_box( 'sts_instalador_details', 'Dados de Contato da Empresa', 'sts_capital_instalador_meta_callback', 'instalador', 'normal', 'high' );
    add_meta_box( 'sts_instalador_location', 'Localização da Empresa (Busca Inteligente)', 'sts_capital_location_metabox_callback', 'instalador', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'sts_capital_add_instalador_meta' );

function sts_capital_location_metabox_callback($post) {
    $current_terms = wp_get_post_terms($post->ID, 'regiao');
    $current_city_id = !empty($current_terms) ? $current_terms[0]->term_id : 0;
    $current_state_id = 0;
    
    if ($current_city_id) {
        $term = get_term($current_city_id, 'regiao');
        $current_state_id = ($term->parent == 0) ? $term->term_id : $term->parent;
        if ($term->parent == 0) $current_city_id = 0; // Se for estado, limpa a cidade selecionada
    }

    $states = get_terms(array('taxonomy' => 'regiao', 'parent' => 0, 'hide_empty' => false));
    ?>
    <div id="sts-location-admin">
        <p><strong>Estado:</strong></p>
        <select id="admin-state-select" style="width:100%">
            <option value="">Selecione o Estado</option>
            <?php foreach ($states as $state) : ?>
                <option value="<?php echo $state->term_id; ?>" <?php selected($current_state_id, $state->term_id); ?>><?php echo esc_html($state->name); ?></option>
            <?php endforeach; ?>
        </select>

        <p><strong>Cidade:</strong></p>
        <select id="admin-city-select" name="tax_input[regiao][]" style="width:100%" <?php echo !$current_state_id ? 'disabled' : ''; ?>>
            <option value="">Selecione a Cidade</option>
            <?php 
            if ($current_state_id) {
                $cities = get_terms(array('taxonomy' => 'regiao', 'parent' => $current_state_id, 'hide_empty' => false));
                foreach ($cities as $city) {
                    echo '<option value="'.$city->term_id.'" '.selected($current_city_id, $city->term_id, false).'>'.$city->name.'</option>';
                }
            }
            ?>
        </select>
        <input type="hidden" name="tax_input[regiao][]" value="<?php echo $current_state_id; ?>" id="admin-state-hidden">
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#admin-state-select').on('change', function() {
            var stateId = $(this).val();
            $('#admin-state-hidden').val(stateId);
            $('#admin-city-select').html('<option value="">Carregando...</option>').prop('disabled', true);

            if (!stateId) return;

            $.getJSON(ajaxurl, {action: 'sts_get_cities', state_id: stateId}, function(data) {
                var html = '<option value="">Selecione a Cidade</option>';
                $.each(data, function(i, city) {
                    html += '<option value="'+city.id+'">'+city.name+'</option>';
                });
                $('#admin-city-select').html(html).prop('disabled', false);
            });
        });
    });
    </script>
    <?php
}

function sts_capital_instalador_meta_callback( $post ) {
    $whatsapp = get_post_meta($post->ID, '_sts_whatsapp', true);
    $phone = get_post_meta($post->ID, '_sts_phone', true);
    $email = get_post_meta($post->ID, '_sts_email', true);
    $website = get_post_meta($post->ID, '_sts_website', true);
    $is_premium = get_post_meta($post->ID, '_sts_is_premium', true);
    ?>
    <div style="background: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin-bottom: 20px;">
        <label style="font-weight: bold; color: #856404;">
            <input type="checkbox" name="sts_is_premium" value="1" <?php checked($is_premium, '1'); ?>> 
            ESTADO PREMIUM (Destaque Ouro no Portal)
        </label>
    </div>
    <p><label>WhatsApp (com DDD):</label><br><input type="text" name="sts_whatsapp" value="<?php echo esc_attr($whatsapp); ?>" style="width:100%"></p>
    <p><label>Telefone Fixo:</label><br><input type="text" name="sts_phone" value="<?php echo esc_attr($phone); ?>" style="width:100%"></p>
    <p><label>E-mail Corporativo:</label><br><input type="text" name="sts_email" value="<?php echo esc_attr($email); ?>" style="width:100%"></p>
    <p><label>Website Oficial:</label><br><input type="url" name="sts_website" value="<?php echo esc_attr($website); ?>" style="width:100%"></p>
    <p style="grid-column: span 2;"><label>Endereço Físico (Rua, Número, Bairro):</label><br><input type="text" name="sts_address" value="<?php echo esc_attr(get_post_meta($post->ID, '_sts_address', true)); ?>" style="width:100%"></p>
    <?php
}

// Save Installer Meta
function sts_capital_save_instalador_meta($post_id) {
    if ( array_key_exists('sts_whatsapp', $_POST) ) update_post_meta($post_id, '_sts_whatsapp', sanitize_text_field($_POST['sts_whatsapp']));
    if ( array_key_exists('sts_phone', $_POST) ) update_post_meta($post_id, '_sts_phone', sanitize_text_field($_POST['sts_phone']));
    if ( array_key_exists('sts_email', $_POST) ) update_post_meta($post_id, '_sts_email', sanitize_email($_POST['sts_email']));
    if ( array_key_exists('sts_website', $_POST) ) update_post_meta($post_id, '_sts_website', esc_url_raw($_POST['sts_website']));
    if ( array_key_exists('sts_address', $_POST) ) update_post_meta($post_id, '_sts_address', sanitize_text_field($_POST['sts_address']));
    update_post_meta($post_id, '_sts_is_premium', isset($_POST['sts_is_premium']) ? '1' : '0');
}
add_action( 'save_post', 'sts_capital_save_instalador_meta' );

/**
 * Filter: Order installers by Premium first
 */
function sts_capital_order_installers_by_premium( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive('instalador') || is_tax('regiao') ) ) {
        
        // Se filtramos por Estado (regiao_parent) mas não escolhemos Cidade (regiao)
        if ( isset($_GET['regiao_parent']) && !empty($_GET['regiao_parent']) && empty($_GET['regiao']) ) {
            $tax_query = array(
                array(
                    'taxonomy' => 'regiao',
                    'field'    => 'term_id',
                    'terms'    => intval($_GET['regiao_parent']),
                    'include_children' => true,
                )
            );
            $query->set('tax_query', $tax_query);
        }

        $query->set('meta_key', '_sts_is_premium');
        $query->set('orderby', array(
            'meta_value' => 'DESC',
            'date'       => 'DESC'
        ));
    }
}
add_action( 'pre_get_posts', 'sts_capital_order_installers_by_premium' );

/**
 * Handle Business Hub Submission (Front-end)
 */
function sts_capital_handle_instalador_submission() {
    if ( isset($_POST['sts_hub_nonce']) && wp_verify_nonce($_POST['sts_hub_nonce'], 'sts_hub_action') ) {
        
        // Turnstile Verification
        if ( !sts_verify_turnstile($_POST['cf-turnstile-response']) ) {
            wp_redirect(add_query_arg('submission', 'captcha_error', $_POST['_wp_http_referer']));
            exit;
        }

        $title   = sanitize_text_field($_POST['hub_name']);
        $content = sanitize_textarea_field($_POST['hub_desc']);
        $email   = sanitize_email($_POST['hub_email']);
        $whatsapp= sanitize_text_field($_POST['hub_whatsapp']);
        $website = esc_url_raw($_POST['hub_website']);
        $location= sanitize_text_field($_POST['hub_location']);

        // Check/Create User
        $user_id = email_exists($email);
        if ( !$user_id ) {
            $random_password = wp_generate_password( 12, false );
            $user_id = wp_create_user( $email, $random_password, $email );
            wp_update_user( array( 'ID' => $user_id, 'role' => 'instalador_parceiro', 'display_name' => $title ) );
            
            // In a real scenario, you'd send an email here.
            // wp_mail($email, 'Sua conta no Capital Consciente', "Sua senha temporária: $random_password");
        }

        $post_id = wp_insert_post(array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'pending',
            'post_type'    => 'instalador',
            'post_author'  => $user_id
        ));

        if ( $post_id ) {
            update_post_meta($post_id, '_sts_email', $email);
            update_post_meta($post_id, '_sts_whatsapp', $whatsapp);
            update_post_meta($post_id, '_sts_website', $website);
            update_post_meta($post_id, '_sts_location_raw', $location);

            wp_redirect(add_query_arg('submission', 'success', $_POST['_wp_http_referer']));
        } else {
            wp_redirect(add_query_arg('submission', 'error', $_POST['_wp_http_referer']));
        }
        exit;
    }
}
/**
 * Handle Business HUB REGISTRATION/**
 * 1. Registro Simplificado (Apenas User/Assinante)
 */
function sts_capital_handle_company_registration() {
    if ( isset($_POST['sts_company_registration']) && wp_verify_nonce($_POST['sts_reg_nonce'], 'sts_reg_action') ) {
        
        $user_email = sanitize_email($_POST['user_email']);
        $user_pass  = $_POST['user_pass'];
        $user_name  = sanitize_text_field($_POST['user_name']);

        if ( email_exists($user_email) ) {
            wp_redirect( add_query_arg('reg', 'email_exists', home_url('/cadastro-empresa')) );
            exit;
        }

        $user_id = wp_create_user($user_email, $user_pass, $user_email);
        
        if ( is_wp_error($user_id) ) {
            wp_redirect( add_query_arg('reg', 'error', home_url('/cadastro-empresa')) );
            exit;
        }

        wp_update_user(array(
            'ID' => $user_id,
            'display_name' => $user_name,
            'first_name' => $user_name
        ));

        // Logar Automaticamente
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

        wp_redirect( home_url('/dashboard-instalador?onboarding=1') );
        exit;
    }
}
add_action('admin_post_nopriv_sts_company_registration', 'sts_capital_handle_company_registration');
add_action('admin_post_sts_company_registration', 'sts_capital_handle_company_registration');

/**
 * 2. Onboarding da Empresa (Dentro do Dashboard)
 */
function sts_capital_handle_onboarding() {
    if ( isset($_POST['sts_onboarding_company']) && is_user_logged_in() ) {
        $user_id = get_current_user_id();

        $company_name = sanitize_text_field($_POST['company_name']);
        $bio          = sanitize_textarea_field($_POST['company_bio']);
        $whatsapp     = sanitize_text_field($_POST['company_whatsapp']);
        $website      = esc_url_raw($_POST['company_website']);
        $address      = sanitize_text_field($_POST['company_address']);
        $regiao       = sanitize_text_field($_POST['regiao']);

        $post_id = wp_insert_post(array(
            'post_title'   => $company_name,
            'post_content' => $bio,
            'post_status'  => 'pending',
            'post_type'    => 'instalador',
            'post_author'  => $user_id
        ));

        if ( !is_wp_error($post_id) ) {
            update_post_meta($post_id, '_sts_whatsapp', $whatsapp);
            update_post_meta($post_id, '_sts_website', $website);
            update_post_meta($post_id, '_sts_address', $address);
            update_user_meta($user_id, '_sts_company_id', $post_id);

            if ( !empty($regiao) ) {
                wp_set_object_terms($post_id, $regiao, 'regiao');
            }

            // Logo Upload
            if ( !empty($_FILES['company_logo']['name']) ) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                $attachment_id = media_handle_upload('company_logo', $post_id);
                if ( !is_wp_error($attachment_id) ) {
                    set_post_thumbnail($post_id, $attachment_id);
                }
            }

            wp_redirect( home_url('/dashboard-instalador?success=1') );
            exit;
        }
    }
}
add_action('admin_post_sts_onboarding_company', 'sts_capital_handle_onboarding');

/**
 * Handle Business Hub LOGIN
 */
function sts_capital_handle_instalador_login() {
    if ( isset($_POST['sts_login_nonce']) && wp_verify_nonce($_POST['sts_login_nonce'], 'sts_login_action') ) {
        
        // Turnstile Verification
        if ( !sts_verify_turnstile($_POST['cf-turnstile-response']) ) {
            wp_redirect(add_query_arg('login', 'captcha_error', $_POST['_wp_http_referer']));
            exit;
        }

        $creds = array(
            'user_login'    => $_POST['log'],
            'user_password' => $_POST['pwd'],
            'remember'      => true
        );
        $user = wp_signon( $creds, false );
        if ( is_wp_error($user) ) {
            wp_redirect(add_query_arg('login', 'failed', $_POST['_wp_http_referer']));
        } else {
            wp_redirect(home_url('/dashboard-instalador'));
        }
        exit;
    }
}
add_action('admin_post_nopriv_sts_instalador_login', 'sts_capital_handle_instalador_login');
add_action('admin_post_sts_instalador_login', 'sts_capital_handle_instalador_login');

/**
 * Handle Business Hub UPDATE (From Dashboard)
 */
function sts_capital_handle_instalador_update() {
    if ( isset($_POST['sts_update_nonce']) && wp_verify_nonce($_POST['sts_update_nonce'], 'sts_update_action') ) {
        if ( !is_user_logged_in() ) exit;

        $post_id = intval($_POST['post_id']);
        $current_user_id = get_current_user_id();
        $post_author = get_post_field('post_author', $post_id);

        if ( $current_user_id != $post_author && !current_user_can('manage_options') ) exit;

        $update_data = array(
            'ID'           => $post_id,
            'post_title'   => sanitize_text_field($_POST['hub_name']),
            'post_content' => sanitize_textarea_field($_POST['hub_desc']),
            'post_status'  => 'pending' // BACK TO PENDING FOR MODERATION
        );

        wp_update_post($update_data);
        update_post_meta($post_id, '_sts_whatsapp', sanitize_text_field($_POST['hub_whatsapp']));
        update_post_meta($post_id, '_sts_phone', sanitize_text_field($_POST['hub_phone']));
        update_post_meta($post_id, '_sts_website', esc_url_raw($_POST['hub_website']));
        update_post_meta($post_id, '_sts_address', sanitize_text_field($_POST['hub_address']));

        // Salvar a Região (Cidade)
        if ( isset($_POST['regiao']) && !empty($_POST['regiao']) ) {
            wp_set_object_terms($post_id, $_POST['regiao'], 'regiao');
        } elseif ( isset($_POST['regiao_parent']) && !empty($_POST['regiao_parent']) ) {
            wp_set_object_terms($post_id, intval($_POST['regiao_parent']), 'regiao');
        }

        wp_redirect(add_query_arg('update', 'success', $_POST['_wp_http_referer']));
        exit;
    }
}
add_action('admin_post_sts_instalador_update', 'sts_capital_handle_instalador_update');


// Admin Dashboard for Leads
/**
 * ADMIN: Hub Management Center (Grouping all features)
 */
function sts_capital_admin_menus() {
    // Main Hub Menu
    add_menu_page('Hub Solar', 'Hub Solar', 'manage_options', 'sts-hub', 'sts_capital_hub_dashboard', 'dashicons-hammer', 25);
    
    // Submenu: Management
    add_submenu_page('sts-hub', 'Gestão de Empresas', 'Gestão de Empresas', 'manage_options', 'sts-hub', 'sts_capital_hub_dashboard');
    
    // Submenu: Leads (Moving existing lead menu here)
    add_submenu_page('sts-hub', 'Inscritos Newsletter', 'Leads Newsletter', 'manage_options', 'sts-leads', 'sts_capital_leads_page');
}
add_action('admin_menu', 'sts_capital_admin_menus');
/**
 * ALGORITMO DE ROTATIVIDADE JUSTA (Fair Rotation)
 * Prioriza Premium no topo e randomiza entre eles para exposição igual.
 */
function sts_capital_sort_installers($query) {
    if (!is_admin() && $query->is_main_query() && (is_post_type_archive('instalador') || is_tax('regiao'))) {
        
        // Define que os posts devem ser ordenados pelo meta_key de premium
        $query->set('meta_key', '_sts_premium');
        $query->set('orderby', array(
            'meta_value_num' => 'DESC', // Premium (1) primeiro, Básicos (0/vazio) depois
            'rand'           => 'ASC'  // Randomiza quem tem o mesmo valor de premium
        ));
    }
}
add_action('pre_get_posts', 'sts_capital_sort_installers');

/**
 * NEWSLETTER HANDLER: Captura de Leads
 */
function sts_capital_handle_newsletter() {
    global $wpdb;
    
    $email = sanitize_email($_POST[ 'email' ]);
    
    if ( !is_email($email) ) {
        wp_send_json_error('E-mail inválido.');
    }

    $table_name = $wpdb->prefix . 'sts_newsletter_leads';
    
    // Verifica se já existe
    $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE email = %s", $email));
    
    if ($exists) {
        wp_send_json_error('Este e-mail já está em nossa lista.');
    }

    $result = $wpdb->insert($table_name, array(
        'time'  => current_time('mysql'),
        'email' => $email
    ));

    if ($result) {
        wp_send_json_success('Inscrição realizada com sucesso!');
    } else {
        wp_send_json_error('Erro ao salvar. Tente novamente.');
    }
}
add_action('wp_ajax_sts_newsletter', 'sts_capital_handle_newsletter');
add_action('wp_ajax_nopriv_sts_newsletter', 'sts_capital_handle_newsletter');

/**
 * BREADCRUMBS: Sinalização para SEO (Silo Architecture)
 */
function sts_capital_breadcrumbs() {
    if (is_front_page()) return;

    echo '<nav class="flex text-[10px] font-black uppercase tracking-widest text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2 scrollbar-hide" aria-label="Breadcrumb">';
    echo '<ol class="inline-flex items-center space-x-2">';
    echo '<li><a href="'.home_url().'" class="hover:text-primary transition-colors">Home</a></li>';

    if (is_post_type_archive('instalador') || is_tax('regiao') || is_singular('instalador')) {
        echo '<li class="flex items-center gap-2"><span class="text-[8px] opacity-30">/</span> <a href="'.home_url('/instaladores/').'" class="hover:text-primary transition-colors">Instaladores</a></li>';
        
        if (is_tax('regiao')) {
            $term = get_queried_object();
            if ($term->parent != 0) {
                $parent = get_term($term->parent, 'regiao');
                echo '<li class="flex items-center gap-2"><span class="text-[8px] opacity-30">/</span> <a href="'.get_term_link($parent).'" class="hover:text-primary transition-colors">'.$parent->name.'</a></li>';
            }
            echo '<li class="flex items-center gap-2 text-primary"><span class="text-[8px] opacity-30 text-slate-400">/</span> '.$term->name.'</li>';
        }

        if (is_singular('instalador')) {
            $terms = wp_get_post_terms(get_the_ID(), 'regiao');
            if ($terms) {
                $term = $terms[0];
                if ($term->parent != 0) {
                    $parent = get_term($term->parent, 'regiao');
                    echo '<li class="flex items-center gap-2"><span class="text-[8px] opacity-30">/</span> <a href="'.get_term_link($parent).'" class="hover:text-primary transition-colors">'.$parent->name.'</a></li>';
                }
                echo '<li class="flex items-center gap-2"><span class="text-[8px] opacity-30">/</span> <a href="'.get_term_link($term).'" class="hover:text-primary transition-colors">'.$term->name.'</a></li>';
            }
            echo '<li class="flex items-center gap-2 text-primary font-bold"><span class="text-[8px] opacity-30 text-slate-400">/</span> '.get_the_title().'</li>';
        }
    } elseif (is_single()) {
        echo '<li class="flex items-center gap-2"><span class="text-[8px] opacity-30">/</span> Blog</li>';
    } elseif (is_page()) {
        echo '<li class="flex items-center gap-2 text-primary"><span class="text-[8px] opacity-30 text-slate-400">/</span> '.get_the_title().'</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

/**
 * REVIEWS & RATINGS: Sistema Nativo de Avaliações
 */

// 1. Adiciona o campo de estrelas no formulário de comentário
function sts_capital_add_rating_field() {
    if (is_singular('instalador')) {
        echo '<div class="mb-6">';
        echo '<label class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Sua Avaliação</label>';
        echo '<div class="flex gap-2 rating-stars">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<label class="cursor-pointer">
                    <input type="radio" name="sts_rating" value="'.$i.'" class="hidden" '.($i == 5 ? 'checked' : '').'>
                    <span class="material-symbols-outlined text-slate-300 hover:text-amber-400 transition-colors star-icon" data-value="'.$i.'">star</span>
                  </label>';
        }
        echo '</div>';
        echo '</div>';
        
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-icon');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const val = this.dataset.value;
                    stars.forEach(s => {
                        if (s.dataset.value <= val) {
                            s.classList.replace('text-slate-300', 'text-amber-400');
                        } else {
                            s.classList.replace('text-amber-400', 'text-slate-300');
                        }
                    });
                });
            });
        });
        </script>
        <?php
    }
}
add_action('comment_form_logged_in_after', 'sts_capital_add_rating_field');
add_action('comment_form_after_fields', 'sts_capital_add_rating_field');

// 2. Salva a nota no banco de dados
function sts_capital_save_rating($comment_id) {
    if (isset($_POST['sts_rating'])) {
        update_comment_meta($comment_id, 'sts_rating', intval($_POST['sts_rating']));
    }
}
add_action('comment_post', 'sts_capital_save_rating');

// 3. Função para pegar a média de notas de uma empresa
function sts_capital_get_average_rating($post_id) {
    $comments = get_comments(array('post_id' => $post_id, 'status' => 'approve'));
    if (!$comments) return 0;

    $total_rating = 0;
    $count = 0;
    foreach ($comments as $comment) {
        $rating = get_comment_meta($comment->comment_ID, 'sts_rating', true);
        if ($rating) {
            $total_rating += intval($rating);
            $count++;
        }
    }

    return $count > 0 ? round($total_rating / $count, 1) : 0;
}

// 4. Função para exibir as estrelas visualmente
function sts_capital_display_stars($rating) {
    echo '<div class="flex gap-1">';
    for ($i = 1; $i <= 5; $i++) {
        $color = ($i <= round($rating)) ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700';
        echo '<span class="material-symbols-outlined text-sm '.$color.'">star</span>';
    }
    echo '</div>';
}

/**
 * SEO: JSON-LD Schema para Instaladores (Com Estrelas)
 */
function sts_capital_installer_schema() {
    if (is_singular('instalador')) {
        global $post;
        $id = $post->ID;
        
        $avg_rating = sts_capital_get_average_rating($id);
        $review_count = get_comments_number($id);
        $address = get_post_meta($id, '_sts_address', true);
        $phone = get_post_meta($id, '_sts_phone', true);
        
        $schema = array(
            "@context" => "https://schema.org",
            "@type"    => "LocalBusiness",
            "name"     => get_the_title(),
            "image"    => get_the_post_thumbnail_url($id, 'large'),
            "description" => get_the_excerpt(),
            "url"      => get_permalink(),
        );

        if ($phone) $schema["telephone"] = $phone;
        if ($address) {
            $schema["address"] = array(
                "@type" => "PostalAddress",
                "streetAddress" => $address
            );
        }

        if ($avg_rating > 0) {
            $schema["aggregateRating"] = array(
                "@type"       => "AggregateRating",
                "ratingValue" => $avg_rating,
                "reviewCount" => $review_count
            );
        }

        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'sts_capital_installer_schema');

/**
 * STRIPE INTEGRATION: Sistema de Pagamento e Assinaturas
 */
// Tenta carregar as chaves do arquivo local (não enviado ao Git)
if (file_exists(get_template_directory() . '/stripe-config.php')) {
    require_once get_template_directory() . '/stripe-config.php';
}

// Fallback para chaves (Caso o arquivo config não exista, o admin deve definir aqui ou via DB)
if (!defined('STRIPE_PUBLISHABLE_KEY')) define('STRIPE_PUBLISHABLE_KEY', 'INSIRA_SUA_CHAVE_PUBLICA_AQUI');
if (!defined('STRIPE_SECRET_KEY')) define('STRIPE_SECRET_KEY', 'INSIRA_SUA_CHAVE_SECRETA_AQUI');
if (!defined('STRIPE_PRICE_ID')) define('STRIPE_PRICE_ID', 'INSIRA_SEU_PRICE_ID_AQUI');

// Função para gerar o link de pagamento
function sts_capital_create_stripe_session($price_id, $customer_email) {
    if (!$price_id || $price_id === 'INSIRA_SEU_PRICE_ID_AQUI') return false;
    
    $url = 'https://api.stripe.com/v1/checkout/sessions';
    
    $args = array(
        'method'  => 'POST',
        'headers' => array(
            'Authorization' => 'Bearer ' . STRIPE_SECRET_KEY,
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ),
        'body' => http_build_query(array(
            'mode' => 'subscription', 
            'payment_method_types' => array('card'), // Testando apenas com cartão
            'line_items' => array(
                array(
                    'price' => $price_id,
                    'quantity' => 1,
                ),
            ),
            'success_url' => home_url('/dashboard-instalador/?payment=success'),
            'cancel_url' => home_url('/dashboard-instalador/?payment=cancel'),
            'customer_email' => $customer_email,
        )),
    );

    $response = wp_remote_post($url, $args);

    if ( is_wp_error($response) ) {
        wp_die('Erro de Conexão: ' . $response->get_error_message());
    }

    $body = json_decode(wp_remote_retrieve_body($response));
    
    if (isset($body->error)) {
        wp_die('Erro do Stripe: ' . $body->error->message);
    }

    return isset($body->url) ? $body->url : false;
}

// Processa o redirecionamento para o Checkout do Stripe
function sts_capital_process_checkout() {
    if ( isset($_GET['sts_action']) && $_GET['sts_action'] === 'checkout' && is_user_logged_in() ) {
        
        $price_id = STRIPE_PRICE_ID; 
        
        if (!$price_id || $price_id === 'INSIRA_SEU_PRICE_ID_AQUI') {
            wp_die('Erro: O Price ID do Stripe não foi configurado pelo administrador.');
        }

        $current_user = wp_get_current_user();
        $checkout_url = sts_capital_create_stripe_session($price_id, $current_user->user_email);

        if ($checkout_url) {
            wp_redirect($checkout_url);
            exit;
        } else {
            wp_die('Erro ao conectar com o Stripe. Verifique suas chaves de API.');
        }
    }
}
add_action('template_redirect', 'sts_capital_process_checkout');

/**
 * WEBHOOK: Ativação Automática de Premium
 */
add_action('rest_api_init', function () {
    register_rest_route('sts/v1', '/stripe-webhook', array(
        'methods' => 'POST',
        'callback' => 'sts_capital_handle_stripe_webhook',
        'permission_callback' => '__return_true',
    ));
});

function sts_capital_handle_stripe_webhook($request) {
    $payload = $request->get_body();
    $data = json_decode($payload);

    if (!$data) return new WP_Error('no_data', 'Sem dados', array('status' => 400));

    // Evento de Pagamento Bem-sucedido
    if ($data->type === 'checkout.session.completed') {
        $session = $data->data->object;
        $customer_email = $session->customer_details->email;

        // Encontra o usuário pelo e-mail
        $user = get_user_by('email', $customer_email);
        if ($user) {
            // Encontra a empresa (CPT instalador) deste usuário
            $post = get_posts(array(
                'post_type' => 'instalador',
                'author' => $user->ID,
                'post_status' => 'any',
                'posts_per_page' => 1
            ));

            if ($post) {
                update_post_meta($post[0]->ID, '_sts_is_premium', '1');
                update_post_meta($post[0]->ID, '_sts_premium', 1); // Garante o valor numérico para o filtro de busca
            }
        }
    }

    // Evento de Cancelamento/Falha de Assinatura
    if ($data->type === 'customer.subscription.deleted') {
        $subscription = $data->data->object;
        // Aqui precisaríamos de uma lógica mais avançada de mapeamento de Customer ID, 
        // mas por simplicidade no MVP, o admin pode remover manualmente ou podemos mapear o e-mail se disponível.
    }

    return array('status' => 'success');
}

add_action('admin_head', 'sts_capital_admin_styles');

function sts_capital_leads_page() {
    global $wpdb;
    $leads = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "sts_newsletter_leads ORDER BY time DESC");
    ?>
    <div class="wrap">
        <h1>Inscritos na Newsletter (Zero Plugin Lead Collector)</h1>
        <p>Estes e-mails foram coletados diretamente pelo tema.</p>
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th class="manage-column column-columnname" scope="col">E-mail</th>
                    <th class="manage-column column-columnname" scope="col">Data de Inscrição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($leads as $lead): ?>
                <tr>
                    <td><strong><?php echo esc_html($lead->email); ?></strong></td>
                    <td><?php echo esc_html($lead->time); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

/**
 * Item 1: Professional SEO Meta Editor (Replaces SEO Plugins)
 */
function sts_capital_add_seo_meta_boxes() {
    add_meta_box( 'sts_seo_meta', 'Configurações de SEO Avançado', 'sts_capital_seo_meta_box_callback', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sts_capital_add_seo_meta_boxes' );

function sts_capital_seo_meta_box_callback( $post ) {
    $seo_title = get_post_meta( $post->ID, '_sts_seo_title', true );
    $seo_desc = get_post_meta( $post->ID, '_sts_seo_description', true );
    ?>
    <p>
        <label>Título SEO (Vazio usa o título do post):</label><br>
        <input type="text" name="sts_seo_title" value="<?php echo esc_attr($seo_title); ?>" style="width: 100%;"><br>
        <small>Recomendado: Máximo 60 caracteres.</small>
    </p>
    <p>
        <label>Meta Descrição (Vazio usa o resumo):</label><br>
        <textarea name="sts_seo_description" style="width: 100%;" rows="3"><?php echo esc_textarea($seo_desc); ?></textarea><br>
        <small>Recomendado: Máximo 160 caracteres.</small>
    </p>
    <?php
}

/**
 * Item 2: Contact Form Logic (Replaces Contact Plugins)
 */
function sts_capital_handle_contact_form() {
    if ( isset($_POST['sts_contact_nonce']) && wp_verify_nonce($_POST['sts_contact_nonce'], 'sts_contact_action') ) {
        
        // Turnstile Verification
        if ( !sts_verify_turnstile($_POST['cf-turnstile-response']) ) {
            wp_redirect(add_query_arg('contact_sent', 'captcha_error', $_POST['_wp_http_referer']));
            exit;
        }

        $name    = sanitize_text_field($_POST['contact_name']);
        $email   = sanitize_email($_POST['contact_email']);
        $message = sanitize_textarea_field($_POST['contact_message']);
        
        $to      = get_option('admin_email');
        $subject = 'Novo Contato: ' . get_bloginfo('name');
        $body    = "Nome: $name \nE-mail: $email \nMensagem: \n$message";
        $headers = array('Content-Type: text/plain; charset=UTF-8', "From: $name <$email>");

        if ( wp_mail($to, $subject, $body, $headers) ) {
            wp_redirect(add_query_arg('contact_sent', 'success', $_POST['_wp_http_referer']));
        } else {
            wp_redirect(add_query_arg('contact_sent', 'error', $_POST['_wp_http_referer']));
        }
        exit;
    }
}
add_action('admin_post_nopriv_sts_contact_form', 'sts_capital_handle_contact_form');
add_action('admin_post_sts_contact_form', 'sts_capital_handle_contact_form');

/**
 * Item 3: Security & Performance Cleanup (Replaces Security Plugins)
 */
function sts_capital_security_cleanup() {
    // Hide WP Version
    remove_action('wp_head', 'wp_generator');
    // Disable XML-RPC (Spam prevention)
    add_filter('xmlrpc_enabled', '__return_false');
    // Remove RSD Link
    remove_action('wp_head', 'rsd_link');
    // Remove wlwmanifest
    remove_action('wp_head', 'wlwmanifest_link');
    // Remove Shortlinks
    remove_action('wp_head', 'wp_shortlink_wp_head');
    // Remove REST API links from head
    remove_action('wp_head', 'rest_output_link_wp_head');
}
add_action('init', 'sts_capital_security_cleanup');

/**
 * Save All Meta Data
 */
function sts_capital_save_all_meta( $post_id ) {
    if ( array_key_exists( 'sts_content_label', $_POST ) ) {
        update_post_meta( $post_id, '_sts_content_label', sanitize_text_field( $_POST['sts_content_label'] ) );
    }
    if ( array_key_exists( 'sts_seo_title', $_POST ) ) {
        update_post_meta( $post_id, '_sts_seo_title', sanitize_text_field( $_POST['sts_seo_title'] ) );
    }
    if ( array_key_exists( 'sts_seo_description', $_POST ) ) {
        update_post_meta( $post_id, '_sts_seo_description', sanitize_textarea_field( $_POST['sts_seo_description'] ) );
    }
    if ( array_key_exists( 'sts_faq_q', $_POST ) && array_key_exists( 'sts_faq_a', $_POST ) ) {
        $faqs = array();
        foreach ( $_POST['sts_faq_q'] as $i => $q ) {
            if ( !empty($q) ) {
                $faqs[] = array( 'q' => sanitize_text_field($q), 'a' => sanitize_textarea_field($_POST['sts_faq_a'][$i]) );
            }
        }
        update_post_meta( $post_id, '_sts_faqs', $faqs );
    }
}
add_action( 'save_post', 'sts_capital_save_all_meta' );

/**
 * Custom Post Meta: Labels
 */
function sts_capital_add_meta_boxes() {
    add_meta_box( 'sts_content_label', 'Etiqueta de Conteúdo', 'sts_capital_label_meta_box_callback', 'post', 'side' );
    add_meta_box( 'sts_faq_section', 'Perguntas Frequentes (FAQ SEO)', 'sts_capital_faq_meta_box_callback', 'post', 'normal' );
}
add_action( 'add_meta_boxes', 'sts_capital_add_meta_boxes' );

function sts_capital_faq_meta_box_callback( $post ) {
    $faqs = get_post_meta( $post->ID, '_sts_faqs', true ) ?: array();
    ?>
    <div id="faq-wrapper">
        <?php if (!empty($faqs)): foreach($faqs as $index => $faq): ?>
            <div class="faq-item" style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <input type="text" name="sts_faq_q[]" value="<?php echo esc_attr($faq['q']); ?>" placeholder="Pergunta" style="width: 100%; margin-bottom: 5px;"><br>
                <textarea name="sts_faq_a[]" placeholder="Resposta" style="width: 100%;" rows="2"><?php echo esc_textarea($faq['a']); ?></textarea>
            </div>
        <?php endforeach; else: ?>
            <div class="faq-item" style="margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <input type="text" name="sts_faq_q[]" value="" placeholder="Pergunta" style="width: 100%; margin-bottom: 5px;"><br>
                <textarea name="sts_faq_a[]" placeholder="Resposta" style="width: 100%;" rows="2"></textarea>
            </div>
        <?php endif; ?>
    </div>
    <button type="button" onclick="addFaqRow()" class="button">Adicionar Pergunta</button>
    <script>
        function addFaqRow() {
            const wrapper = document.getElementById('faq-wrapper');
            const div = document.createElement('div');
            div.className = 'faq-item';
            div.style.marginBottom = '15px';
            div.style.borderBottom = '1px solid #eee';
            div.style.paddingBottom = '10px';
            div.innerHTML = '<input type="text" name="sts_faq_q[]" placeholder="Pergunta" style="width: 100%; margin-bottom: 5px;"><br><textarea name="sts_faq_a[]" placeholder="Resposta" style="width: 100%;" rows="2"></textarea>';
            wrapper.appendChild(div);
        }
    </script>
    <?php
}

function sts_capital_save_meta_box_data( $post_id ) {
    if ( array_key_exists( 'sts_content_label', $_POST ) ) {
        update_post_meta( $post_id, '_sts_content_label', sanitize_text_field( $_POST['sts_content_label'] ) );
    }
    if ( array_key_exists( 'sts_faq_q', $_POST ) && array_key_exists( 'sts_faq_a', $_POST ) ) {
        $faqs = array();
        foreach ( $_POST['sts_faq_q'] as $i => $q ) {
            if ( !empty($q) ) {
                $faqs[] = array(
                    'q' => sanitize_text_field($q),
                    'a' => sanitize_textarea_field($_POST['sts_faq_a'][$i])
                );
            }
        }
        update_post_meta( $post_id, '_sts_faqs', $faqs );
    }
}
add_action( 'save_post', 'sts_capital_save_meta_box_data' );

function sts_capital_label_meta_box_callback( $post ) {
    $label = get_post_meta( $post->ID, '_sts_content_label', true );
    ?>
    <p>
        <label>Tipo de Conteúdo:</label><br>
        <select name="sts_content_label" style="width:100%">
            <option value="noticia" <?php selected($label, 'noticia'); ?>>Notícia</option>
            <option value="opiniao" <?php selected($label, 'opiniao'); ?>>Opinião</option>
            <option value="analise" <?php selected($label, 'analise'); ?>>Análise</option>
            <option value="patrocinado" <?php selected($label, 'patrocinado'); ?>>Patrocinado</option>
        </select>
    </p>
    <p>
        <label>Fonte Original (Nome):</label><br>
        <input type="text" name="sts_source_name" value="<?php echo esc_attr($source_name); ?>" style="width:100%">
    </p>
    <p>
        <label>Fonte Original (URL):</label><br>
        <input type="url" name="sts_source_url" value="<?php echo esc_attr($source_url); ?>" style="width:100%">
    </p>
    <?php
}

function sts_capital_save_meta( $post_id ) {
    if ( isset( $_POST['sts_content_label'] ) ) update_post_meta( $post_id, '_sts_content_label', sanitize_text_field( $_POST['sts_content_label'] ) );
    if ( isset( $_POST['sts_source_name'] ) ) update_post_meta( $post_id, '_sts_source_name', sanitize_text_field( $_POST['sts_source_name'] ) );
    if ( isset( $_POST['sts_source_url'] ) ) update_post_meta( $post_id, '_sts_source_url', esc_url_raw( $_POST['sts_source_url'] ) );
}
add_action( 'save_post', 'sts_capital_save_meta' );

/**
 * JSON-LD NewsArticle Schema
 */
function sts_capital_inject_schema() {
    if ( is_single() ) {
        global $post;
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => 'NewsArticle',
            "headline" => get_the_title(),
            "datePublished" => get_the_date('c'),
            "dateModified" => get_the_modified_date('c'),
            "author" => array(
                '@type' => 'Person',
                'name' => get_the_author(),
                'url' => get_author_posts_url(get_the_author_meta('ID')),
                'jobTitle' => get_the_author_meta('expertise'),
                'sameAs' => array_filter(array(
                    get_the_author_meta('linkedin'),
                    get_the_author_meta('twitter'),
                    get_the_author_meta('website')
                ))
            ),
            "publisher" => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url() ?: 'https://via.placeholder.com/600x60'
                )
            ),
            "articleBody" => wp_strip_all_tags(get_the_content()),
            "mainEntityOfPage" => array(
                '@type' => 'WebPage',
                '@id' => get_permalink()
            )
        );
        if ( has_post_thumbnail() ) {
            $img_id = get_post_thumbnail_id(get_the_ID());
            $img_meta = wp_get_attachment_image_src($img_id, 'full');
            $schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => $img_meta[0],
                'width' => $img_meta[1],
                'height' => $img_meta[2]
            );
        }

        echo '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';

        // Breadcrumb Schema
        $categories = get_the_category();
        $breadcrumb = array(
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => array(
                array(
                    "@type" => "ListItem",
                    "position" => 1,
                    "name" => "Home",
                    "item" => home_url()
                )
            )
        );
        if ( !empty($categories) ) {
            $breadcrumb['itemListElement'][] = array(
                "@type" => "ListItem",
                "position" => 2,
                "name" => $categories[0]->name,
                "item" => get_category_link($categories[0]->term_id)
            );
            $breadcrumb['itemListElement'][] = array(
                "@type" => "ListItem",
                "position" => 3,
                "name" => get_the_title(),
                "item" => get_permalink()
            );
        }
        echo '<script type="application/ld+json">' . json_encode( $breadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';

        // FAQ Schema injection
        $faqs = get_post_meta(get_the_ID(), '_sts_faqs', true);
        if (!empty($faqs)) {
            $faq_schema = array(
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => array()
            );
            foreach ($faqs as $faq) {
                $faq_schema['mainEntity'][] = array(
                    "@type" => "Question",
                    "name" => $faq['q'],
                    "acceptedAnswer" => array(
                        "@type" => "Answer",
                        "text" => $faq['a']
                    )
                );
            }
            echo '<script type="application/ld+json">' . json_encode( $faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
        }
    }

    // LocalBusiness Schema for Installers
    if ( is_singular('instalador') ) {
        global $post;
        $local_schema = array(
            "@context" => "https://schema.org",
            "@type" => "ProfessionalService",
            "name" => get_the_title(),
            "description" => get_the_excerpt(),
            "url" => get_permalink(),
            "address" => array(
                "@type" => "PostalAddress",
                "streetAddress" => get_post_meta($post->ID, '_sts_address', true),
                "addressLocality" => get_post_meta($post->ID, '_sts_location_raw', true)
            ),
            "telephone" => get_post_meta($post->ID, '_sts_phone', true),
            "contactPoint" => array(
                "@type" => "ContactPoint",
                "telephone" => get_post_meta($post->ID, '_sts_whatsapp', true),
                "contactType" => "sales"
            )
        );
        if ( has_post_thumbnail() ) {
            $local_schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'full');
        }
        echo '<script type="application/ld+json">' . json_encode( $local_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
    }
}
add_action( 'wp_head', 'sts_capital_inject_schema' );


/**
 * Helper to display ad if exists
 */
function sts_display_ad($slot_id, $placeholder = '') {
    $ad_code = get_theme_mod("sts_ad_$slot_id");
    if ( !empty($ad_code) ) {
        echo '<div class="sts-ad-slot sts-ad-' . esc_attr($slot_id) . ' flex justify-center w-full overflow-hidden">' . $ad_code . '</div>';
    } elseif ( !empty($placeholder) && current_user_can('manage_options') ) {
        echo $placeholder;
    }
}

/**
 * Register Customizer Ad Slots
 */
function sts_capital_customize_register($wp_customize) {
    // Section: Publicidade
    $wp_customize->add_section('sts_ads_section', array(
        'title'    => 'Publicidade & Anúncios',
        'priority' => 30,
    ));

    $slots = array(
        'top_billboard' => 'Billboard Superior (Home/Arquivos)',
        'in_feed_ad'    => 'Banner In-Feed (Home)',
        'sidebar_top_ad' => 'Banner Lateral Topo',
        'sidebar_bottom_ad' => 'Banner Lateral Rodapé',
        'article_middle_ad' => 'Anúncio Meio do Artigo',
        'article_bottom_ad' => 'Banner Final do Artigo'
    );

    foreach ($slots as $id => $label) {
        $wp_customize->add_setting("sts_ad_$id", array(
            'default'           => '',
            'sanitize_callback' => 'sts_sanitize_ad_code', // Custom sanitization for HTML/JS
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control("sts_ad_$id", array(
            'label'    => $label,
            'section'  => 'sts_ads_section',
            'type'     => 'textarea',
            'description' => 'Cole aqui o código HTML/AdSense.',
        ));
    }
}
add_action('customize_register', 'sts_capital_customize_register');

/**
 * Sanitization for Ad Codes (Allow scripts/HTML)
 */
function sts_sanitize_ad_code($input) {
    if ( current_user_can('unfiltered_html') ) {
        return $input;
    }
    return wp_kses_post($input);
}

/**
 * Automatically Inject Ad in the Middle of Post Content
 */
function sts_capital_inject_middle_ad($content) {
    if ( !is_single() ) return $content;

    $ad_code = get_theme_mod('sts_ad_article_middle_ad');
    if ( empty($ad_code) ) return $content;

    $closing_p = '</p>';
    $paragraphs = explode($closing_p, $content);
    $total_p = count($paragraphs);
    
    // Inject after paragraph 3 (if exists), otherwise in the middle
    $insert_at = ($total_p > 4) ? 3 : floor($total_p / 2);
    
    foreach ($paragraphs as $index => $paragraph) {
        if ( trim($paragraph) ) {
            $paragraphs[$index] .= $closing_p;
        }

        if ( $index === (int)$insert_at ) {
            $ad_html = '<div class="sts-ad-middle my-12 py-8 border-y border-slate-100 dark:border-slate-800 flex flex-col items-center gap-4 bg-slate-50/50 dark:bg-slate-900/50 rounded-2xl">';
            $ad_html .= '<span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Publicidade no Meio do Insight</span>';
            $ad_html .= $ad_code;
            $ad_html .= '</div>';
            $paragraphs[$index] .= $ad_html;
        }
    }

    return implode('', $paragraphs);
}
add_filter('the_content', 'sts_capital_inject_middle_ad', 10);

/**
 * Inject Open Graph and Twitter Meta Tags
 */
function sts_capital_inject_social_meta() {
    if ( is_singular() ) {
        global $post;
        $seo_title = get_post_meta($post->ID, '_sts_seo_title', true);
        $seo_desc = get_post_meta($post->ID, '_sts_seo_description', true);
        
        $title = $seo_title ?: get_the_title();
        $desc = $seo_desc ?: wp_trim_words(get_the_excerpt(), 25);
        $url = get_permalink();
        $img = get_the_post_thumbnail_url($post->ID, 'large');
        $site_name = get_bloginfo('name');

        echo "\n<!-- Social Meta Assets -->\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
        if ($img) {
            echo '<meta property="og:image" content="' . esc_url($img) . '">' . "\n";
        }
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
        if ($img) {
            echo '<meta name="twitter:image" content="' . esc_url($img) . '">' . "\n";
        }
    }
}
add_action( 'wp_head', 'sts_capital_inject_social_meta', 5 );

/**
 * EEAT: Custom Author Fields
 */
function sts_capital_author_fields( $user ) {
    ?>
    <h3>E-E-A-T Expertise</h3>
    <table class="form-table">
        <tr>
            <th><label for="expertise">Especialidade (ex: Engenheiro Solar)</label></th>
            <td><input type="text" name="expertise" value="<?php echo esc_attr( get_the_author_meta( 'expertise', $user->ID ) ); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'sts_capital_author_fields' );
add_action( 'edit_user_profile', 'sts_capital_author_fields' );

function sts_capital_save_author_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        update_user_meta( $user_id, 'expertise', sanitize_text_field( $_POST['expertise'] ) );
    }
}
add_action( 'personal_options_update', 'sts_capital_save_author_fields' );
add_action( 'edit_user_profile_update', 'sts_capital_save_author_fields' );

/**
 * Compliance: Auto-add rel="sponsored" to links in sponsored content
 */
function sts_capital_auto_sponsored_links( $content ) {
    if ( is_single() ) {
        $label = get_post_meta( get_the_ID(), '_sts_content_label', true );
        if ( $label === 'patrocinado' ) {
            // This is a simple regex to add rel="sponsored" if it doesn't exist
            $content = preg_replace_callback( '/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1/i', function( $matches ) {
                $link = $matches[0];
                if ( strpos( $link, 'rel=' ) === false ) {
                    return str_replace( '<a ', '<a rel="sponsored" ', $link );
                } else {
                    return preg_replace( '/rel=(["\'])(.*?)\1/i', 'rel=$1$2 sponsored$1', $link );
                }
            }, $content );
        }
    }
    return $content;
}
add_filter( 'the_content', 'sts_capital_auto_sponsored_links' );

/**
 * Google News Sitemap
 * URL: /sitemap-news.xml
 */
function sts_capital_news_sitemap_rewrite() {
    add_rewrite_rule( 'sitemap-news\.xml$', 'index.php?sts_news_sitemap=1', 'top' );
}
add_action( 'init', 'sts_capital_news_sitemap_rewrite' );

function sts_capital_query_vars( $vars ) {
    $vars[] = 'sts_news_sitemap';
    return $vars;
}
add_filter( 'query_vars', 'sts_capital_query_vars' );

function sts_capital_news_sitemap_output() {
    if ( get_query_var( 'sts_news_sitemap' ) ) {
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 1000,
            'date_query'     => array(
                array(
                    'after' => '48 hours ago',
                ),
            ),
        );
        $query = new WP_Query( $args );

        header( 'Content-Type: application/xml; charset=utf-8' );
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                echo '<url>';
                echo '<loc>' . get_permalink() . '</loc>';
                echo '<news:news>';
                echo '<news:publication>';
                echo '<news:name>' . esc_xml( get_bloginfo( 'name' ) ) . '</news:name>';
                echo '<news:language>pt-br</news:language>';
                echo '</news:publication>';
                echo '<news:publication_date>' . get_the_date( 'c' ) . '</news:publication_date>';
                echo '<news:title>' . esc_xml( get_the_title() ) . '</news:title>';
                echo '</news:news>';
                echo '</url>';
            }
        }
        echo '</urlset>';
        wp_reset_postdata();
        exit;
    }
}
add_action( 'template_redirect', 'sts_capital_news_sitemap_output' );

/**
 * Mobile Menu JS - Updated for Tailwind Design
 */
function sts_capital_mobile_menu_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function() {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden', 'opacity-0', '-translate-y-4');
                    mobileMenu.classList.add('flex', 'opacity-100', 'translate-y-0');
                    document.body.style.overflow = 'hidden';
                } else {
                    mobileMenu.classList.add('hidden', 'opacity-0', '-translate-y-4');
                    mobileMenu.classList.remove('flex', 'opacity-100', 'translate-y-0');
                    document.body.style.overflow = '';
                }
            });
        }

        // Dropdown toggles for mobile
        const dropdownItems = document.querySelectorAll('.menu-item-has-children > a');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (window.innerWidth < 1024) {
                    const subMenu = this.nextElementSibling;
                    if (subMenu) {
                        e.preventDefault();
                        subMenu.classList.toggle('hidden');
                        const icon = this.querySelector('.dropdown-arrow');
                        if (icon) icon.classList.toggle('rotate-180');
                    }
                }
            });
        });
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'sts_capital_mobile_menu_script' );

/**
 * Custom Tailwind Walker for wp_nav_menu
 */
class STS_Tailwind_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"lg:absolute lg:top-full lg:left-0 lg:hidden lg:group-hover:block bg-white dark:bg-slate-900 shadow-xl border border-slate-200 dark:border-slate-800 rounded-lg py-4 min-w-[200px] z-50 flex flex-col gap-2 p-4 ml-4 lg:ml-0\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $has_children = in_array('menu-item-has-children', $classes);

        // Get the current page to highlight active link
        $is_current = in_array('current-menu-item', $classes);
        $link_class = 'font-manrope tracking-tight font-bold uppercase text-xs transition-all duration-200 flex items-center justify-between ';
        
        if ($depth == 0) {
            $link_class .= 'p-2 ';
            if ($is_current) {
                $link_class .= 'text-emerald-600 dark:text-emerald-400 border-b-2 border-emerald-500 pb-1';
            } else {
                $link_class .= 'text-slate-600 dark:text-slate-400 hover:text-emerald-500';
            }
        } else {
            $link_class .= 'p-2 text-slate-500 dark:text-slate-400 hover:text-emerald-500 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-md';
        }

        $output .= '<li class="' . esc_attr($class_names) . ' relative group">';
        $output .= '<a href="' . esc_attr($item->url) . '" class="' . $link_class . '">';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        
        if ($has_children) {
            $output .= '<span class="material-symbols-outlined dropdown-arrow text-[16px] ml-1 transition-transform group-hover:rotate-180">expand_more</span>';
        }
        
        $output .= '</a>';
    }
}

/**
 * Módulo: Otimização de Imagens Nativa (Zero Plugin Suite)
 * Substitui: Smush, WebP Express, Regenerate Thumbnails
 */

// 1. Forçar conversão automática para WebP em todos os uploads e tamanhos gerados
add_filter( 'image_editor_output_format', function( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
} );

// 2. Definir qualidade de compressão (Equilíbrio Performance/Qualidade)
add_filter( 'wp_editor_set_quality', function( $quality, $mime_type ) {
    if ( 'image/webp' === $mime_type || 'image/jpeg' === $mime_type ) {
        return 82; // 82% é o padrão ouro de otimização
    }
    return $quality;
}, 10, 2 );

// 3. Registrar tamanhos compatíveis com Google Discover (Mínimo 1200px)
function sts_capital_setup_image_sizes() {
    // Tamanho padrão para Google Discover (16:9 High Res)
    add_image_size( 'google-discover', 1200, 675, true ); 
    // Tamanho para o Hub de Instaladores
    add_image_size( 'hub-logo', 400, 400, false );
    // Tamanho para Grid de Notícias
    add_image_size( 'news-grid', 800, 450, true );
}
add_action( 'after_setup_theme', 'sts_capital_setup_image_sizes' );

// 4. Habilitar upload de tipos modernos no WordPress (incluindo SVG para logos)
function sts_capital_mime_types($mimes) {
    $mimes['webp'] = 'image/webp';
    $mimes['svg']  = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'sts_capital_mime_types');

// 8. Sanitização Extra: Remover acentos e espaços de arquivos (Essencial para Google News)
function sts_sanitize_filename_seo($filename) {
    $filename = remove_accents($filename);
    $filename = strtolower($filename);
    $filename = preg_replace('/[^a-z0-0-_\.]/', '-', $filename);
    return $filename;
}
add_filter('sanitize_file_name', 'sts_sanitize_filename_seo', 10);

/**
 * Script de Emergência: Regenerar tamanhos de imagens existentes
 * Como usar: Acesse seu-site.com/wp-admin/?sts_regenerate=1
 * Use apenas uma vez para criar os tamanhos 'google-discover'.
 */
function sts_capital_manual_regenerate() {
    if ( is_admin() && isset($_GET['sts_regenerate']) && current_user_can('manage_options') ) {
        $images = get_posts( array( 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => -1 ) );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        foreach ( $images as $image ) {
            $file = get_attached_file( $image->ID );
            $metadata = wp_generate_attachment_metadata( $image->ID, $file );
            wp_update_attachment_metadata( $image->ID, $metadata );
        }
        wp_die('Imagens regeneradas com sucesso para o novo padrão WebP e Discover! Clique em voltar.');
    }
}
add_action('admin_init', 'sts_capital_manual_regenerate');

/**
 * Importador Inteligente: Estados e Cidades do IBGE (Zero Plugin)
 * URL para ativar: seusite.com/wp-admin/?sts_import_brasil=1
 */
function sts_capital_import_ibge_data() {
    if ( is_admin() && isset($_GET['sts_import_brasil']) && current_user_can('manage_options') ) {
        
        // Aumentar limites para o XAMPP aguentar
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        wp_suspend_cache_addition(true);

        $taxonomy = 'regiao';
        // ... (resto do array de UFs igual)
        $ufs = array(
            11 => 'Rondônia', 12 => 'Acre', 13 => 'Amazonas', 14 => 'Roraima', 15 => 'Pará', 16 => 'Amapá', 
            17 => 'Tocantins', 21 => 'Maranhão', 22 => 'Piauí', 23 => 'Ceará', 24 => 'Rio Grande do Norte', 
            25 => 'Paraíba', 26 => 'Pernambuco', 27 => 'Alagoas', 28 => 'Sergipe', 29 => 'Bahia', 31 => 'Minas Gerais', 
            32 => 'Espírito Santo', 33 => 'Rio de Janeiro', 35 => 'São Paulo', 41 => 'Paraná', 42 => 'Santa Catarina', 
            43 => 'Rio Grande do Sul', 50 => 'Mato Grosso do Sul', 51 => 'Mato Grosso', 52 => 'Goiás', 53 => 'Distrito Federal'
        );

        echo "<style>body{font-family:sans-serif;background:#f0f2f5;padding:40px;line-height:1.6} .card{background:#white;padding:20px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}</style>";
        echo "<div class='card'><h2>🚀 Motor de Importação Ativado</h2>";
        echo "<p>Processando 5.570 municípios. Aguarde...</p><hr>";
        flush();

        foreach ( $ufs as $uf_id => $uf_name ) {
            $parent = term_exists( $uf_name, $taxonomy );
            if ( ! $parent ) {
                $parent = wp_insert_term( $uf_name, $taxonomy );
            }
            $parent_id = is_array($parent) ? $parent['term_id'] : $parent;

            if ( ! is_wp_error($parent_id) ) {
                // Verificar se já temos cidades para este estado (para pular se já foi feito)
                $children = get_term_children($parent_id, $taxonomy);
                if (count($children) > 10) {
                    echo "✅ <strong>$uf_name</strong> já está completo. Pulando...<br>";
                    flush();
                    continue;
                }

                echo "⏳ Importando cidades de <strong>$uf_name</strong>... ";
                $response = wp_remote_get( "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf_id/municipios" );
                
                if ( ! is_wp_error( $response ) ) {
                    $cidades = json_decode( wp_remote_retrieve_body( $response ) );
                    foreach ( $cidades as $cidade ) {
                        wp_insert_term( $cidade->nome, $taxonomy, array( 'parent' => $parent_id ) );
                    }
                    echo "OK!<br>";
                    flush();
                }
            }
        }
        wp_suspend_cache_addition(false);
        wp_die("<h3>🎉 Tudo pronto!</h3> <p>O Brasil inteiro agora está no seu banco de dados.</p> <a href='".admin_url('edit-tags.php?taxonomy=regiao&post_type=instalador')."'>Verificar Termos</a>");
    }
}
add_action( 'admin_init', 'sts_capital_import_ibge_data' );

/**
 * AJAX: Buscar cidades dinamicamente por estado
 */
function sts_get_cities_callback() {
    $state_id = intval($_GET['state_id']);
    $cities = get_terms(array(
        'taxonomy' => 'regiao',
        'parent'   => $state_id,
        'hide_empty' => false,
        'orderby' => 'name',
        'order'   => 'ASC'
    ));
    
    $output = array();
    foreach ($cities as $city) {
        $output[] = array('id' => $city->term_id, 'name' => $city->name, 'slug' => $city->slug);
    }
    wp_send_json($output);
}
add_action('wp_ajax_sts_get_cities', 'sts_get_cities_callback');
add_action('wp_ajax_nopriv_sts_get_cities', 'sts_get_cities_callback');

/**
 * FIM DO MÓDULO DE OTIMIZAÇÃO
 */

/**
 * Criação automática de páginas essenciais (Hub de Instaladores)
 */
function sts_capital_auto_create_pages() {
    $pages = array(
        'dashboard-instalador' => array(
            'title'    => 'Dashboard do Instalador',
            'template' => 'page-dashboard-instalador.php'
        ),
        'cadastro-empresa' => array(
            'title'    => 'Cadastro de Empresa',
            'template' => 'page-cadastro-empresa.php'
        ),
        'login-instalador' => array(
            'title'    => 'Login do Instalador',
            'template' => 'page-login-instalador.php'
        )
    );

    foreach ($pages as $slug => $data) {
        $query = new WP_Query(array('pagename' => $slug, 'post_type' => 'page'));
        if ( !$query->have_posts() ) {
            $page_id = wp_insert_post(array(
                'post_title'   => $data['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ));
            if ( $page_id && !empty($data['template']) ) {
                update_post_meta($page_id, '_wp_page_template', $data['template']);
            }
        }
    }
    
    // Forçar flush das regras de permalink para evitar 404
    if ( get_option('sts_permalinks_flushed') !== 'yes' ) {
        flush_rewrite_rules();
        update_option('sts_permalinks_flushed', 'yes');
    }
}
add_action('init', 'sts_capital_auto_create_pages');

/**
 * 1. ADMIN DASHBOARD PAGE: Gestão do Hub Solar
 */
function sts_capital_hub_dashboard() {
    global $wpdb;

    // Stats
    $total_installers   = wp_count_posts('instalador');
    $pending_installers = $total_installers->pending;
    $active_installers  = $total_installers->publish;
    
    $premium_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = '_sts_is_premium' AND meta_value = '1'");

    // Handle Quick Actions
    if ( isset($_GET['action']) && isset($_GET['post_id']) && current_user_can('manage_options') ) {
        $pid = intval($_GET['post_id']);
        if ( $_GET['action'] === 'approve' ) {
            wp_publish_post($pid);
            echo '<div class="notice notice-success is-dismissible"><p>Empresa aprovada e publicada!</p></div>';
        } elseif ( $_GET['action'] === 'make_premium' ) {
            update_post_meta($pid, '_sts_is_premium', '1');
            echo '<div class="notice notice-success is-dismissible"><p>Status PREMIUM aplicado com sucesso!</p></div>';
        }
    }

    ?>
    <style>
        .sts-admin-dashboard { font-family: 'Inter', sans-serif; background: #f0f2f5; margin-left: -20px; padding: 40px; }
        .sts-box { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 30px; border: 1px solid #e2e8f0; }
        .sts-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: #fff; padding: 30px; border-radius: 24px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; }
        .stat-card .label { font-size: 11px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 15px; }
        .stat-card .value { font-size: 36px; font-weight: 900; color: #0f172a; line-height: 1; }
        .stat-card.premium { border-bottom: 4px solid #f59e0b; }
        .stat-card.pending { border-bottom: 4px solid #ef4444; }
        
        .sts-table { width: 100%; border-collapse: collapse; }
        .sts-table th { text-align: left; padding: 15px 20px; background: #f8fafc; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; }
        .sts-table td { padding: 20px; border-bottom: 1px solid #f8fafc; font-size: 13px; font-weight: 500; vertical-align: middle; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .badge.pending { background: #fff7ed; color: #c2410c; }
        .badge.premium { background: #fef3c7; color: #92400e; }
        
        .btn-action { text-decoration: none; padding: 8px 16px; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s; }
        .btn-approve { background: #10b981; color: #fff; }
        .btn-approve:hover { background: #059669; transform: translateY(-1px); }
        .title-area h1 { font-size: 28px; font-weight: 900; color: #0f172a; margin-bottom: 10px; letter-spacing: -0.02em; }
    </style>

    <div class="sts-admin-dashboard">
        <div class="title-area">
            <h1>Central de Comando Hub Solar</h1>
            <p style="color: #64748b; margin-bottom: 40px;">Gerencie o ecossistema de instaladores e parceiros do portal.</p>
        </div>

        <div class="sts-grid">
            <div class="stat-card">
                <span class="label">Total de Empresas</span>
                <span class="value"><?php echo $active_installers + $pending_installers; ?></span>
            </div>
            <div class="stat-card pending">
                <span class="label">Empresas Pendentes</span>
                <span class="value"><?php echo $pending_installers; ?></span>
            </div>
            <div class="stat-card premium">
                <span class="label">Parceiros Ouro</span>
                <span class="value"><?php echo $premium_count; ?></span>
            </div>
        </div>

        <?php if ($pending_installers > 0) : ?>
        <div class="sts-box">
            <h2 style="font-weight: 900; margin-bottom: 25px;">⏳ Aguardando Aprovação</h2>
            <table class="sts-table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Nome da Empresa</th>
                        <th>Responsável</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pending_query = new WP_Query(array('post_type' => 'instalador', 'post_status' => 'pending', 'posts_per_page' => 10));
                    while ($pending_query->have_posts()) : $pending_query->the_post();
                    ?>
                    <tr>
                        <td><?php echo get_the_post_thumbnail(get_the_ID(), array(40, 40), array('style' => 'border-radius:8px')); ?></td>
                        <td><strong><?php the_title(); ?></strong></td>
                        <td><?php echo get_the_author(); ?></td>
                        <td><?php echo get_the_date(); ?></td>
                        <td>
                            <a href="?page=sts-hub&action=approve&post_id=<?php the_ID(); ?>" class="btn-action btn-approve">Aprovar Agora</a>
                            <a href="<?php echo get_edit_post_link(); ?>" style="color: #64748b; font-size: 11px; margin-left:15px">Editar Detalhes</a>
                        </td>
                    </tr>
                    <?php endwhile; wp_reset_postdata(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div class="sts-box">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
                <h2 style="font-weight: 900; margin:0">🏢 Parceiros Ativos</h2>
                <a href="<?php echo admin_url('edit.php?post_type=instalador'); ?>&_sts_is_premium=1" class="btn-action" style="background: #f8fafc; color: #0f172a; border: 1px solid #e2e8f0;">Ver Todos no Sistema</a>
            </div>
            
            <table class="sts-table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Empresa</th>
                        <th>Localização</th>
                        <th>Status</th>
                        <th>Ações Rápis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $active_query = new WP_Query(array('post_type' => 'instalador', 'post_status' => 'publish', 'posts_per_page' => 5));
                    while ($active_query->have_posts()) : $active_query->the_post();
                        $is_premium = get_post_meta(get_the_ID(), '_sts_is_premium', true);
                        $location = get_post_meta(get_the_ID(), '_sts_location_raw', true);
                    ?>
                    <tr>
                        <td><?php echo get_the_post_thumbnail(get_the_ID(), array(40, 40), array('style' => 'border-radius:8px')); ?></td>
                        <td><strong><?php the_title(); ?></strong></td>
                        <td><span style="color: #64748b; font-size:12px"><?php echo $location; ?></span></td>
                        <td>
                            <?php if ($is_premium === '1') : ?>
                                <span class="badge premium">⭐ PREMIUM</span>
                            <?php else : ?>
                                <span class="badge" style="background:#f1f5f9; color:#64748b">GRATUITO</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($is_premium !== '1') : ?>
                                <a href="?page=sts-hub&action=make_premium&post_id=<?php the_ID(); ?>" class="btn-action" style="color: #b45309; background:#fef3c7; border:1px solid #fcd34d">Subir para Premium</a>
                            <?php endif; ?>
                            <a href="<?php echo get_edit_post_link(); ?>" class="btn-action" style="color: #64748b; padding-left:0">Editar</a>
                        </td>
                    </tr>
                    <?php endwhile; wp_reset_postdata(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

/**
 * 2. ADMIN UI CLEANUP: Melhora visual para os Metaboxes (Print do Cliente)
 */
function sts_capital_admin_styles() {
    $screen = get_current_screen();
    if ( $screen->post_type !== 'instalador' ) return;

    ?>
    <style>
        /* Container Principal do Metabox */
        #sts_instalador_details, #sts_instalador_location {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            margin-top: 20px;
        }

        #sts_instalador_details .postbox-header {
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }

        #sts_instalador_details .inside {
            padding: 25px !important;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        #sts_instalador_details p:first-child { /* Checkbox Premium */
            grid-column: span 2;
            background: #fffbeb;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #fef3c7;
            margin-top: 0 !important;
        }

        #sts_instalador_details label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 8px;
            display: block;
        }

        #sts_instalador_details input[type="text"], 
        #sts_instalador_details input[type="email"], 
        #sts_instalador_details input[type="url"] {
            width: 100% !important;
            height: 48px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0 15px;
            box-shadow: none;
            transition: border-color 0.2s;
        }

        #sts_instalador_details input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 1px #10b981;
        }

        /* Metabox de Localização (Side) */
        #sts_instalador_location .inside {
            padding: 15px !important;
        }

        #sts_instalador_location select {
            width: 100% !important;
            height: 40px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            margin-bottom: 15px;
        }

        /* Ocultar elementos desnecessários do Gutenberg no CPT Instalador para limpar a tela */
        .post-type-instalador .editor-post-publish-panel__link,
        .post-type-instalador .editor-post-last-edit {
            display: none !important;
        }
    </style>
    <?php
}
/**
 * SINCRONIZAÇÃO: User -> Post (Assinante para Instalador)
 */
function sts_capital_sync_user_to_post($user_id) {
    // Evitar loop infinito
    remove_action('save_post_instalador', 'sts_capital_sync_post_to_user', 20);

    $user_info = get_userdata($user_id);
    $post_id = get_user_meta($user_id, '_sts_company_id', true);

    // Se não temos o ID guardado, tentamos achar pelo autor
    if (!$post_id) {
        $post = get_posts(array('post_type' => 'instalador', 'author' => $user_id, 'post_status' => 'any', 'posts_per_page' => 1));
        if ($post) {
            $post_id = $post[0]->ID;
            update_user_meta($user_id, '_sts_company_id', $post_id);
        }
    }

    if ($post_id) {
        // Sincronizar E-mail do User com Meta do Post
        update_post_meta($post_id, '_sts_email', $user_info->user_email);
        
        // Se quisermos sincronizar o nome do usuário com algo no post (opcional)
        // update_post_meta($post_id, '_sts_responsavel_nome', $user_info->display_name);
    }

    add_action('save_post_instalador', 'sts_capital_sync_post_to_user', 20, 2);
}
add_action('profile_update', 'sts_capital_sync_user_to_post');

/**
 * SINCRONIZAÇÃO: Post -> User (Instalador para Assinante)
 */
function sts_capital_sync_post_to_user($post_id, $post) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($post->post_type !== 'instalador') return;

    // Evitar loop infinito
    remove_action('profile_update', 'sts_capital_sync_user_to_post');

    $author_id = $post->post_author;
    $new_email = get_post_meta($post_id, '_sts_email', true);

    if ($author_id && is_email($new_email)) {
        $user_data = get_userdata($author_id);
        
        // Se o e-mail no post for diferente do e-mail atual do user, atualiza o user
        if ($user_data && $user_data->user_email !== $new_email) {
            wp_update_user(array(
                'ID'         => $author_id,
                'user_email' => $new_email
            ));
        }
    }

    add_action('profile_update', 'sts_capital_sync_user_to_post');
}
add_action('save_post_instalador', 'sts_capital_sync_post_to_user', 20, 2);
