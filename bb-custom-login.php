<?php
/*
Plugin Name: BB Custom Login
Description: Un plugin pour personnaliser la page de connexion de WordPress
Version: 1.0
Author: Agence BB® Switzerland
Author URI: https://www.agence-bb.ch
*/


// Texte sous le formulaire de connexion
function add_content_to_login_form()
{
    // Ajouter du contenu après le paragraphe #backtoblog dans la div#login
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
            <!-- <div class="sm-space"></div>
            <div class="imageContainer">
                <img src="<?php echo get_theme_file_uri('/login/img/search.jpg'); ?>" alt="">
                <div class="shadow-image"></div>
            </div> -->
            <div class="sm-space"></div>
            <button><a href="https://agence-bb.ch/services/" target="_blank">Voir nos prestations</a></button>
            <!-- <h3 class="h3-crossSelling">Déouvrez nos prestions de référencement payant et gratuit SEO/SEA !</h3> -->
        </div>


        <div class="md-space"></div>

        <div class="section-poles">
            <h3 class="h3-poles">Découvrez également les autres pôles de BB<sup>®</sup> Switzerland.</h3>
            <div class="sm-space"></div>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/strategie.svg'); ?>">
            </a>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/digital-web.svg'); ?>">
            </a>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/graphisme-design.svg'); ?>">
            </a>
            <a href="https://agence-bb.ch/services" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/photos-videos.svg'); ?>">
            </a>
        </div>

        <!-- <div class="section-logo">
            <a href="https://agence-bb.ch/bb-studio" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/BBS_studio_logo.webp'); ?>">
                <p>Les studios photos et vidéos.</p>
            </a>
            <a href="https://agence-bb.ch/blog" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/BBS_blog_logo.webp'); ?>">
                <p>Le blog des experts.</p>
            </a>
            <a href="https://agence-bb.ch/bb-lab" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/BBS_lab_logo.webp'); ?>">
                <p>Le laboratoire digital.</p>
            </a>
            <a href="https://agence-bb.ch/bb-life" target="_blank">
                <img decoding="async" src="<?php echo get_theme_file_uri('/login/img/BBS_life_logo.webp'); ?>">
                <p>L'actualité de l'agence.</p>
            </a>
        </div> -->

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
    echo '<style>
        .login h1.logo-agence a.lien-agence{
            background-image: url(' . get_theme_file_uri('/login/img/logo_bb.png') . ') !important;
            background-size: 150px !important;
            height: 170px !important;
            width: 30% !important
        }
        .login h1.logo-client a{
            background-image: url(' . get_theme_file_uri('/login/img/AGEAS_blue_2.svg') . ') !important;
            background-size: 30% !important;
            height: 170px !important;
            width: auto !important;
        }
        .login h1.logo-agence{
            display: flex;
            justify-content: center;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'custom_login_css');


// Lien vers le CSS personnalisé et le JS personalisé + import font Roboto Flex
function my_custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
    echo '<script src="' . get_theme_file_uri('/login/custom-login-script.js') . '" type="text/javascript" async></script>';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex&display=swap" rel="stylesheet">';
}
add_action('login_head', 'my_custom_login');