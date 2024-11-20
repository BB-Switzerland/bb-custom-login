<?php
/*
Plugin Name: BB Custom Login
Description: Un plugin pour personnaliser la page de connexion de WordPress
Version: 1.0.1
Author: Agence BB® Switzerland
Author URI: https://www.agence-bb.ch
*/

// Texte sous le formulaire de connexion
function add_content_to_login_form()
{
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var backToBlog = document.getElementById("backtoblog");
            var additionalContent = document.createElement("div");
            additionalContent.classList.add("divContact");
            additionalContent.innerHTML = \'<p align="center" id="contact">En cas de problème de connexion ou souhait de modifications de contenus, veuillez contacter notre support Web par email idéalement à <a href="mailto:support@agence-bb.ch">support@agence-bb.ch</a> ou au <a href="tel:+41227923707"> + 41 22 792 37 07</a>. <br> Nous répondons sous 48 heures, jours ouvrables. En cas d’urgence absolue, veuillez contacter votre personne de contact à l’agence.</p>\';
            backToBlog.parentNode.insertBefore(additionalContent, backToBlog.nextSibling);
        });
    </script>';
}
add_action('login_form', 'add_content_to_login_form');

// Création de la section de Cross-selling Agence
function add_header_login()
{
    function cross_selling_login_shortcode()
    {
        ob_start();
        ?>

        <h1 class="logo-agence"><a href="https://agence-bb.ch" target="_blank" class="lien-agence">Un site internet accompagné
                par l'Agence BB<sup>®</sup> Switzerland</a></h1>

        <div class="crossSelling">
            <h2 class="h2-crossSelling">
                Boostez votre visibilité en ligne avec nos prestations de référencement SEO/SEA !
            </h2>
            <div class="sm-space"></div>
            <button><a href="https://agence-bb.ch/services/" target="_blank">Voir nos prestations</a></button>
        </div>

        <div class="md-space"></div>

        <div class="section-poles">
            <h3 class="h3-poles">Découvrez également les autres pôles de BB<sup>®</sup> Switzerland.</h3>
            <div class="sm-space"></div>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo plugin_dir_url(__FILE__) . 'login/img/strategie.svg'; ?>">
            </a>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo plugin_dir_url(__FILE__) . 'login/img/digital-web.svg'; ?>">
            </a>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo plugin_dir_url(__FILE__) . 'login/img/graphisme-design.svg'; ?>">
            </a>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo plugin_dir_url(__FILE__) . 'login/img/photos-videos.svg'; ?>">
            </a>
        </div>

        <?php
        $content = ob_get_clean();
        $existing_content = '<div class="login-custom-div-child">' . $content . '</div>';
        return $existing_content;
    }
    add_shortcode('CrossSellingLogin', 'cross_selling_login_shortcode');

    function add_custom_div_to_login()
    {
        echo '<section class="login-custom-section">' . do_shortcode('[CrossSellingLogin]') . '</section>';
    }
    add_action('login_enqueue_scripts', 'add_custom_div_to_login');
}

add_header_login();

// CSS personnalisé pour l'élément login h1 a
function custom_login_css()
{
    $client_logo = get_option('bb_custom_login_logo');
    if (!$client_logo) {
        $client_logo = plugin_dir_url(__FILE__) . 'login/img/default-client-logo.svg';
    }

    $primary_color = get_option('bb_custom_login_primary_color', '#01104f');

    echo '<style>
        :root {
            --primary-color-login: ' . esc_attr($primary_color) . ';
        }
        #login h1 a{
            background-image: url(' . esc_url($client_logo) . ') !important;
            background-size: contain !important;
            height: 170px !important;
            width: auto !important;
            display: block;
        }
        .login h1.logo-agence a.lien-agence{
            background-image: url(' . plugin_dir_url(__FILE__) . 'login/img/logo_bb.png) !important;
            background-size: 150px !important;
            height: 170px !important;
            width: 30% !important;
            background-repeat: no-repeat;
            background-position: center;
            color: transparent;
        }
        .login h1.logo-agence{
            display: flex;
            justify-content: center;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'custom_login_css');

// Lien vers le CSS personnalisé et le JS personnalisé + import de la police Roboto Flex
function my_custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . plugin_dir_url(__FILE__) . 'login/custom-login-styles.css" />';
    echo '<script src="' . plugin_dir_url(__FILE__) . 'login/custom-login-script.js" type="text/javascript" async></script>';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Roboto+Flex&display=swap" rel="stylesheet">';
    echo '<script src="https://cdn.tailwindcss.com"></script>';
}
add_action('login_head', 'my_custom_login');

// Ajout de la page de paramètres pour choisir le logo du client et la couleur principale
function bb_custom_login_menu()
{
    add_options_page(
        'BB Custom Login Settings', // Titre de la page
        'BB Custom Login', // Titre du menu
        'manage_options', // Capacité requise
        'bb-custom-login', // Slug du menu
        'bb_custom_login_settings_page' // Fonction de rappel
    );
}
add_action('admin_menu', 'bb_custom_login_menu');

function bb_custom_login_register_settings()
{
    register_setting('bb_custom_login_settings_group', 'bb_custom_login_logo');
    register_setting('bb_custom_login_settings_group', 'bb_custom_login_primary_color');
}
add_action('admin_init', 'bb_custom_login_register_settings');

function bb_custom_login_settings_page()
{
    ?>
    <div class="wrap">
        <h1>Paramètres de BB Custom Login</h1>
        <form method="post" action="options.php">
            <?php settings_fields('bb_custom_login_settings_group'); ?>
            <?php do_settings_sections('bb_custom_login_settings_group'); ?>
            <table class="form-table">
                <!-- Champ pour le logo du client -->
                <tr valign="top">
                    <th scope="row">Logo du client</th>
                    <td>
                        <input type="text" id="bb_custom_login_logo" name="bb_custom_login_logo"
                            value="<?php echo esc_attr(get_option('bb_custom_login_logo')); ?>" style="width:60%;" />
                        <input type="button" id="bb_custom_login_logo_button" class="button" value="Téléverser le logo" />
                        <p class="description">Téléversez ou sélectionnez le logo du client à afficher sur la page de
                            connexion.</p>
                        <?php if (get_option('bb_custom_login_logo')): ?>
                            <img src="<?php echo esc_url(get_option('bb_custom_login_logo')); ?>"
                                style="max-width: 200px; display: block; margin-top: 10px;" />
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Nouveau champ pour la couleur principale -->
                <tr valign="top">
                    <th scope="row">Couleur principale</th>
                    <td>
                        <input type="text" id="bb_custom_login_primary_color" name="bb_custom_login_primary_color"
                            value="<?php echo esc_attr(get_option('bb_custom_login_primary_color', '#01104f')); ?>"
                            class="my-color-field" data-default-color="#01104f" />
                        <p class="description">Sélectionnez la couleur principale à utiliser sur la page de connexion.</p>
                    </td>
                </tr>

            </table>
            <?php submit_button(); ?>
        </form>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            // Pour le champ du logo du client
            var mediaUploader;
            $('#bb_custom_login_logo_button').click(function (e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media({
                    title: 'Choisir le logo',
                    button: {
                        text: 'Choisir le logo'
                    }, multiple: false
                });
                mediaUploader.on('select', function () {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#bb_custom_login_logo').val(attachment.url);
                });
                mediaUploader.open();
            });

            // Pour le champ de sélection de couleur
            $('.my-color-field').wpColorPicker();
        });
    </script>
    <?php
}

// Enqueue des scripts de la médiathèque WordPress et du sélecteur de couleur sur la page de paramètres du plugin
function bb_custom_login_enqueue_media_uploader($hook)
{
    if ($hook != 'settings_page_bb-custom-login') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'bb_custom_login_enqueue_media_uploader');
